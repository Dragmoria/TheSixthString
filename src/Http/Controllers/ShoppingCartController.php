<?php

namespace Http\Controllers;

use Lib\Database\Entity\Coupon;
use Lib\Enums\AddressType;
use Lib\Enums\MolliePaymentStatus;
use Lib\Enums\PaymentMethod;
use Lib\MVCCore\Application;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\JsonResponse;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Service\AddressService;
use Service\CouponService;
use Service\OrderService;
use Service\PaymentService;
use Service\ProductService;
use Service\ShoppingCartService;

class ShoppingCartController extends Controller {
    public function index(): ?Response {
        $response = new ViewResponse();

        $data = $this->getShoppingCartContent(null);
        $response->setBody(view(VIEWS_PATH . 'ShoppingCart.view.php', ['data' => $data])->withLayout(MAIN_LAYOUT));

        return $response;
    }

    public function deleteItem(): ?Response {
        $postBody = $this->currentRequest->postObject->body();
        $shoppingCartItemId = $postBody["id"];

        $result = new \stdClass();
        $result->success = Application::resolve(ShoppingCartService::class)->deleteItem($_SESSION["user"]["id"] ?? null, $_SESSION["sessionUserGuid"], $shoppingCartItemId);

        $response = new JsonResponse();
        $response->setBody((array)$result);
        return $response;
    }

    public function addItem(): ?Response {
        $postBody = $this->currentRequest->postObject->body();

        $productId = $postBody["productId"];
        $quantity = $postBody["quantity"];

        $response = new JsonResponse();
        $result = new \stdClass();

        $this->validateProductAmountValidAndAvailable($productId, $quantity, $result);
        if($result->success) {
            $result->success = Application::resolve(ShoppingCartService::class)->addItem($_SESSION["user"]["id"] ?? null, $_SESSION["sessionUserGuid"], $productId, $quantity);
        }

        $response->setBody((array)$result);

        return $response;
    }

    public function changeQuantity(): ?Response {
        $postBody = $this->currentRequest->postObject->body();

        $productId = $postBody["productId"];
        $quantity = $postBody["quantity"];

        $response = new JsonResponse();
        $result = new \stdClass();

        $this->validateProductAmountValidAndAvailable($productId, $quantity, $result);
        if($result->success) {
            $result->success = Application::resolve(ShoppingCartService::class)->changeQuantity($_SESSION["user"]["id"] ?? null, $_SESSION["sessionUserGuid"], $productId, $quantity);
        }

        $response->setBody((array)$result);
        return $response;
    }

    public function paymentView(): ?Response {
        $response = new ViewResponse();

        $data = $this->getShoppingCartContent(null);
        if(is_null($data)) {
            redirect('/ShoppingCart');
        }

        $response->setBody(view(VIEWS_PATH . 'ShoppingCartPayment.view.php', ['data' => $data])->withLayout(MAIN_LAYOUT));

        return $response;
    }

    public function personalInformationView(): ?Response {
        $response = new ViewResponse();

        $data = $this->getShoppingCartContent(null);
        if(is_null($data)) {
            redirect('/ShoppingCart');
        }

        $addressService = Application::resolve(AddressService::class);
        $addresses = array();

        foreach(AddressType::cases() as $addressType) {
            $addresses[] = $addressService->getAddressByUserId($_SESSION["user"]["id"], $addressType->value);
        }

        $response->setBody(view(VIEWS_PATH . 'ShoppingCartPersonalInformation.view.php', [
            'fullName' => $_SESSION["user"]["fullname"],
            'addresses' => $addresses,
            'data' => $data
        ])->withLayout(MAIN_LAYOUT));

        return $response;
    }

    public function startPayment(): ?Response {
        $postBody = $this->currentRequest->postObject->body();

        $shoppingCart = Application::resolve(ShoppingCartService::class)->getShoppingCartByUser($_SESSION["user"]["id"], "");

        $couponService = Application::resolve(CouponService::class);
        $couponUsed = $couponService->getCouponByCode($_SESSION["couponApplied"]);
        if(!$couponService->verifyCoupon($couponUsed)) $couponUsed = null;

        $response = new JsonResponse();
        $result = new \stdClass();

        $orderService = Application::resolve(OrderService::class);
        $result->success = $orderService->createOrderWithOrderItems($shoppingCart, $couponUsed);

        $this->removeCoupon();

        $paymentService = Application::resolve(PaymentService::class);
        $createdOrderId = $orderService->getLastCreatedOrderIdForUser($shoppingCart->userId);

        $paymentMethod = PaymentMethod::fromString($postBody["paymentMethod"]);
        $paymentId = null;
        if($postBody["paymentMethod"] != PaymentMethod::PayLater->name) {
            $payment = $paymentService->createPayment($createdOrderId, strtolower($paymentMethod->toString()));
            $paymentId = $payment->id;
            $result->paymentUrl = $payment->getCheckoutUrl();
        }

        $paymentService->createOrderPayment($createdOrderId, $paymentMethod, $paymentId);

        $_SESSION["paymentOrderId"] = $createdOrderId;
        $_SESSION["paymentSendUnpaidMail"] = true;

        $response->setBody((array)$result);
        return $response;
    }

    public function doPayment($data): void {
        $orderId = (int)$data["orderid"];

        $isUserOrder = Application::resolve(OrderService::class)->isUserOrder($orderId, $_SESSION["user"]["id"]);
        if(!$isUserOrder) {
            redirect('/');
        }

        $paymentService = Application::resolve(PaymentService::class);
        $isPaid = $paymentService->isOrderPaid($orderId, $_SESSION["user"]["id"]);
        if($isPaid) {
            redirect("/ShoppingCart/FinishPayment");
        }

        $payment = $paymentService->getPaymentByOrderId($orderId);
        if($payment->status != MolliePaymentStatus::Open->value) {
            $payment = $paymentService->createPayment($orderId, $payment->method);
            $paymentService->updateOrderPayment($orderId, $payment->id);
        }

        $_SESSION["paymentOrderId"] = $orderId;
        $_SESSION["paymentSendUnpaidMail"] = false;

        redirect($payment->getCheckoutUrl());
    }

    public function finishPayment(): ?Response {
        $response = new ViewResponse();

        $paymentOrderId = $_SESSION["paymentOrderId"];
        $paymentSendUnpaidMail = $_SESSION["paymentSendUnpaidMail"];

        if(is_null($paymentOrderId)) {
            redirect('/Account');
        }

        $_SESSION["paymentOrderId"] = null;
        $_SESSION["paymentSendUnpaidMail"] = null;

        $paymentService = Application::resolve(PaymentService::class);
        $payment = $paymentService->getPaymentByOrderId($paymentOrderId);
        $paymentStatus = MolliePaymentStatus::fromString($payment->status);

        if($paymentStatus == MolliePaymentStatus::Paid) {
            $paymentService->setOrderPaymentPaid($paymentOrderId);

            $response->setBody(view(VIEWS_PATH . 'FinishPayment.view.php', [
                'message' => 'Bedankt voor je betaling, je bestelling zal zo snel mogelijk worden verwerkt.'
            ])->withLayout(MAIN_LAYOUT));
            return $response;
        }

        $viewMessage = '';
        if((bool)$paymentSendUnpaidMail) {
            $paymentService->sendPaymentUnsuccessfulMail($paymentOrderId, $_SESSION["user"]["id"]);
            $viewMessage = 'Betaling niet gelukt. Je ontvangt een e-mail met daarin een betaallink, probeer het hiermee opnieuw.';
        } else {
            $viewMessage = 'Betaling niet gelukt, probeer het later opnieuw of neem contact met ons op.';
        }

        $response->setBody(view(VIEWS_PATH . 'FinishPayment.view.php', ['message' => $viewMessage])->withLayout(MAIN_LAYOUT));

        return $response;
    }

    public function processCoupon(): ?Response {
        $postBody = $this->currentRequest->postObject->body();

        $response = new JsonResponse();
        $result = new \stdClass();

        $couponService = Application::resolve(CouponService::class);
        $coupon = $couponService->getCouponByCode($postBody["code"]);
        $result->success = $couponService->verifyCoupon($coupon);
        if($result->success) {
            $shoppingCartData = $this->getShoppingCartContent($coupon);
            $totalPriceInclTaxWithDiscount = Application::resolve(OrderService::class)->calculateTotalPriceInclTaxWithCouponDiscount($coupon, $shoppingCartData->totalPriceIncludingTax);

            $result->discount = "-" . formatPrice($shoppingCartData->totalPriceIncludingTax - $totalPriceInclTaxWithDiscount);
            $result->adjustedTotal = formatPrice($totalPriceInclTaxWithDiscount);

            $_SESSION["couponApplied"] = $postBody["code"];
        }

        $response->setBody((array)$result);
        return $response;
    }

    public function removeCoupon(): void {
        $_SESSION["couponApplied"] = null;
    }

    private function getShoppingCartContent(?Coupon $coupon) {
        $result = Application::resolve(ShoppingCartService::class)->getShoppingCartContent($_SESSION["user"]["id"] ?? null, $_SESSION["sessionUserGuid"]);
        if(is_null($result)) return null;
        $result->totalPriceIncludingTaxCouponApplied = $result->totalPriceIncludingTax;

        if(is_null($coupon) && isset($_SESSION["couponApplied"])) {
            $couponService = Application::resolve(CouponService::class);
            $coupon = $couponService->getCouponByCode($_SESSION["couponApplied"]);

            if($couponService->verifyCoupon($coupon)) {
                $result->totalPriceIncludingTaxCouponApplied = Application::resolve(OrderService::class)->calculateTotalPriceInclTaxWithCouponDiscount($coupon, $result->totalPriceIncludingTax);
            }
        }

        return $result;
    }

    private function validateProductAmountValidAndAvailable(int $productId, int $quantity, \stdClass &$resultObject): void {
        $resultObject->success = true;

        if($quantity <= 0) {
            $resultObject->success = false;
            $resultObject->message = "Kies een geldig aantal";

            return;
        }

        $amountInStock = Application::resolve(ProductService::class)->getAmountInStockForProduct($productId);

        $isChosenAmountInStock = $amountInStock >= $quantity;
        $resultObject->success = $isChosenAmountInStock;
        $resultObject->message = !$isChosenAmountInStock ? "Gekozen aantal is niet op voorraad, aantal beschikbaar: $amountInStock" : "";
    }
}