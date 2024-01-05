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
use Lib\Enums\MolliePaymentStatus;
use Lib\Enums\OrderItemStatus;
use Lib\Enums\ShippingStatus;
use Lib\Helpers\TaxHelper;
use Models\OrderModel;

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
            $result = $this->executeQuery($createOrderQuery, [$shoppingCart->userId, $orderTotal, $orderTax, $couponUsed->id ?? null, $shippingAddressId, $invoiceAddressId, MolliePaymentStatus::Open->value, ShippingStatus::AwaitingShipment->value, $currentDateTime]);
            $createdOrderId = $this->getLastCreatedOrderIdForUser($shoppingCart->userId);

            $result &= $this->handleCreateOrderItems($shoppingCart->id, $createdOrderId);

            if($result) {
                $this->executeQuery("delete from shoppingcart where id = ?", [$shoppingCart->id]);
                $this->sendOrderConfirmation($createdOrderId, $shoppingCart->userId);
            }
        } catch(\Exception $ex) {
            $this->executeQuery("update product prod inner join shoppingcartitem cartitem on cartitem.productId = prod.id set prod.amountInStock = prod.amountInStock + cartitem.quantity where cartitem.shoppingCartId = ?", [$shoppingCart->id]);

            throw $ex;
        }

        return $result;
    }

    public function getLastCreatedOrderIdForUser(int $userId): int {
        return $this->executeQuery("select * from `order` where userId = ? order by id desc limit 1", [$userId], Order::class)[0]->id;
    }

    private function setOrderTotalAndTax(int &$orderTotal, int &$orderTax, ShoppingCart $shoppingCart, ?Coupon $couponUsed): void {
        $orderTotal = (float)$this->executeQuery("select (sum(prod.unitPrice * cartitem.quantity)) as totalPrice from product prod inner join shoppingcartitem cartitem on cartitem.productId = prod.id where cartitem.shoppingCartId = ?", [$shoppingCart->id])[0]->totalPrice;
        $orderTotalInclTaxAndCouponUsed = $this->calculateTotalPriceInclTaxWithCouponDiscount($couponUsed, TaxHelper::calculatePriceIncludingTax($orderTotal));
        $this->executeQuery("update coupon set usageAmount = usageAmount + 1 where id = ?", [$couponUsed->id ?? null]);

        $orderTotal = round(TaxHelper::calculatePriceExcludingTax($orderTotalInclTaxAndCouponUsed), 2);
        $orderTax = round(TaxHelper::calculateTax($orderTotal), 2);
    }

    public function isUserOrder(int $orderId, int $userId): bool {
        return $this->executeQuery("select userId from `order` where id = ?", [$orderId])[0]->userId == $userId;
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
            'url' => "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}/Account"
        ]);

        $userEmail = $this->executeQuery("select emailAddress from user where id = ?", [$userId])[0]->emailAddress;
        $mail = new Mail($userEmail,"Bestelbevestiging #$orderId", $mailtemplateCustomer, MailFrom::NOREPLY, "no-reply@thesixthstring.store");
        $mail->send();
    }

    public function getOrdersById(int $userId): ?array
    {
        $query = "SELECT * FROM `order` WHERE userId = ? ORDER BY createdOn DESC;";
        $params = [$userId];

        $result = $this->executeQuery($query, $params, Order::class);

        $models = [];
        foreach ($result as $entity) {
            array_push($models, OrderModel::convertToModel($entity));
        }

        if (count($models) === 0) return null;
        return $models;
    }
}