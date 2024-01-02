<?php

namespace Http\Controllers;

use Lib\Database\Entity\Coupon;
use Lib\Enums\CouponType;
use Lib\Enums\PaymentMethod;
use Lib\MVCCore\Application;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\JsonResponse;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\TextResponse;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Service\CouponService;
use Service\OrderService;
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

    public function startPayment(): ?Response {
        $shoppingCart = Application::resolve(ShoppingCartService::class)->getShoppingCartByUser($_SESSION["user"]["id"], "");

        $couponService = Application::resolve(CouponService::class);
        $couponUsed = $couponService->getCouponByCode($_SESSION["couponApplied"]);
        if(!$couponService->verifyCoupon($couponUsed)) $couponUsed = null;

        $response = new JsonResponse();
        $result = new \stdClass();
        $result->success = Application::resolve(OrderService::class)->createOrderWithOrderItems($shoppingCart, $couponUsed);

        //TODO: betaling afhandelen
        //$postBody = $this->currentRequest->postObject->body();
        //$paymentType = $postBody["paymentMethod"] ?? PaymentMethod::PayLater;
        //$result->success &= handlePayment met mollie

        $this->removeCoupon();

        $response->setBody((array)$result);
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