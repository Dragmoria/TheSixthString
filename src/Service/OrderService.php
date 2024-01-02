<?php

namespace Service;

use EmailTemplates\Mail;
use EmailTemplates\MailFrom;
use EmailTemplates\MailTemplate;
use Lib\Database\Entity\Coupon;
use Lib\Database\Entity\Order;
use Lib\Database\Entity\ShoppingCart;
use Lib\Enums\AddressType;
use Lib\Enums\CouponType;
use Lib\Enums\OrderItemStatus;
use Lib\Enums\PaymentStatus;
use Lib\Enums\ShippingStatus;
use Lib\Helpers\TaxHelper;

class OrderService extends BaseDatabaseService {
    public function createOrderWithOrderItems(ShoppingCart $shoppingCart, ?Coupon $couponUsed): bool {
        $allProductsAvailable = $this->executeQuery("select (count(prod.id) = 0) as allAvailable from product prod inner join shoppingcartitem cartitem on cartitem.productId = prod.id where (cartitem.quantity > prod.amountInStock or prod.active = ?) and cartitem.shoppingCartId = ?", [0, $shoppingCart->id])[0]->allAvailable;
        if(!(bool)$allProductsAvailable) return false;

        try {
            $this->executeQuery("update product prod inner join shoppingcartitem cartitem on cartitem.productId = prod.id set prod.amountInStock = prod.amountInStock - cartitem.quantity where cartitem.shoppingCartId = ?", [$shoppingCart->id]);

            $orderTotal = 0;
            $orderTax = 0;
            $this->setOrderTotalAndTax($orderTotal, $orderTax, $shoppingCart, $couponUsed);

            $shippingAddressId = $this->getAddressIdByType($shoppingCart->userId, AddressType::Shipping);
            $invoiceAddressId = $this->getAddressIdByType($shoppingCart->userId, AddressType::Invoice);
            $currentDateTime = ((array)new \DateTime())['date'];

            $createOrderQuery = "insert into `order` (userId, orderTotal, orderTax, couponId, shippingAddressId, invoiceAddressId, paymentStatus, shippingStatus, createdOn) values (?,?,?,?,?,?,?,?,?)";
            $result = $this->executeQuery($createOrderQuery, [$shoppingCart->userId, $orderTotal, $orderTax, $couponUsed->id ?? null, $shippingAddressId, $invoiceAddressId, PaymentStatus::AwaitingPayment->value, ShippingStatus::AwaitingShipment->value, $currentDateTime]);
            $createdOrderEntity = $this->executeQuery("select * from `order` where userId = ? order by id desc limit 1", [$shoppingCart->userId], Order::class)[0];

            $result &= $this->handleCreateOrderItems($shoppingCart->id, $createdOrderEntity->id);

            if($result) {
                $this->executeQuery("delete from shoppingcart where id = ?", [$shoppingCart->id]);
                $this->sendOrderConfirmation($createdOrderEntity->id, $shoppingCart->userId);
            }
        } catch(\Exception $ex) {
            $this->executeQuery("update product prod inner join shoppingcartitem cartitem on cartitem.productId = prod.id set prod.amountInStock = prod.amountInStock + cartitem.quantity where cartitem.shoppingCartId = ?", [$shoppingCart->id]);

            throw $ex;
        }

        return $result;
    }

    private function setOrderTotalAndTax(int &$orderTotal, int &$orderTax, ShoppingCart $shoppingCart, ?Coupon $couponUsed): void {
        $orderTotal = (float)$this->executeQuery("select sum(prod.unitPrice) as totalPrice from product prod inner join shoppingcartitem cartitem on cartitem.productId = prod.id where cartitem.shoppingCartId = ?", [$shoppingCart->id])[0]->totalPrice;
        $orderTotalInclTaxAndCouponUsed = $this->calculateTotalPriceInclTaxWithCouponDiscount($couponUsed, TaxHelper::calculatePriceIncludingTax($orderTotal));
        $this->executeQuery("update coupon set usageAmount = usageAmount + 1 where id = ?", [$couponUsed->id]);

        $orderTotal = round(TaxHelper::calculatePriceExcludingTax($orderTotalInclTaxAndCouponUsed), 2);
        $orderTax = round(TaxHelper::calculateTax($orderTotal), 2);
    }

    private function getAddressIdByType(int $userId, AddressType $type): int {
        return $this->executeQuery("select id from address where userId = ? and type = ? and active = ?", [$userId, $type->value, 1])[0]->id;
    }

    private function handleCreateOrderItems(int $shoppingCartId, int $orderId): bool {
        $createOrderItemsQuery = "
            insert into orderitem 
            (orderId, productId, unitPrice, quantity, status) 
            select ?, prod.id, prod.unitPrice, cartitem.quantity, ? 
            from shoppingcartitem cartitem 
            inner join product prod on prod.id = cartitem.productId 
            where cartitem.shoppingCartId = ?
";
        return $this->executeQuery($createOrderItemsQuery, [$orderId, OrderItemStatus::Sent->value, $shoppingCartId]);
    }

    public function calculateTotalPriceInclTaxWithCouponDiscount(?Coupon $coupon, float $totalPriceInclTax): float {
        if(is_null($coupon)) return $totalPriceInclTax;

        $result = 0;
        switch($coupon->type) {
            case CouponType::Amount->value:
                $result = $totalPriceInclTax - $coupon->value;
                break;
            case CouponType::Percentage->value:
                $result = $totalPriceInclTax - ($totalPriceInclTax * ($coupon->value / 100));
                break;
            default:
                return $totalPriceInclTax;
        }

        return max($result, 0);
    }

    private function sendOrderConfirmation(int $orderId, int $userId): void {
        $mailtemplateCustomer = new MailTemplate(MAIL_TEMPLATES . 'OrderConfirmationCustomer.php', [
            'url' => "https://www.thesixthstring.store/Account"
        ]);

        $userEmail = $this->executeQuery("select emailAddress from user where id = ?", [$userId])[0]->emailAddress;
        $mail = new Mail($userEmail,"Bestelbevestiging #$orderId", $mailtemplateCustomer, MailFrom::NOREPLY, "no-reply@thesixthstring.store");
        $mail->send();
    }
}