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
use Lib\Enums\SortOrder;
use Lib\Helpers\TaxHelper;
use Lib\MVCCore\Application;
use Models\OrderManagementOrderModel;
use Models\OrderModel;

class OrderService extends BaseDatabaseService
{
    public function createOrderWithOrderItems(ShoppingCart $shoppingCart, ?Coupon $couponUsed): bool
    {
        $allProductsAvailable = $this->executeQuery("select (count(prod.id) = 0) as allAvailable from product prod inner join shoppingcartitem cartitem on cartitem.productId = prod.id where (cartitem.quantity > prod.amountInStock or prod.active = ?) and cartitem.shoppingCartId = ?", [0, $shoppingCart->id])[0]->allAvailable;
        if (!(bool) $allProductsAvailable)
            return false;

        try {
            $this->executeQuery("update product prod inner join shoppingcartitem cartitem on cartitem.productId = prod.id set prod.amountInStock = prod.amountInStock - cartitem.quantity where cartitem.shoppingCartId = ?", [$shoppingCart->id]);

            $orderTotal = 0;
            $orderTax = 0;
            $this->setOrderTotalAndTax($orderTotal, $orderTax, $shoppingCart, $couponUsed);

            $shippingAddressId = $this->getAddressIdByType($shoppingCart->userId, AddressType::Shipping);
            $invoiceAddressId = $this->getAddressIdByType($shoppingCart->userId, AddressType::Invoice);
            $currentDateTime = ((array) new \DateTime())['date'];

            $createOrderQuery = "insert into `order` (userId, orderTotal, orderTax, couponId, shippingAddressId, invoiceAddressId, paymentStatus, shippingStatus, createdOn) values (?,?,?,?,?,?,?,?,?)";
            $result = $this->executeQuery($createOrderQuery, [$shoppingCart->userId, $orderTotal, $orderTax, $couponUsed->id ?? null, $shippingAddressId, $invoiceAddressId, MolliePaymentStatus::Open->value, ShippingStatus::AwaitingShipment->value, $currentDateTime]);
            $createdOrderId = $this->getLastCreatedOrderIdForUser($shoppingCart->userId);

            $result &= $this->handleCreateOrderItems($shoppingCart->id, $createdOrderId);

            if ($result) {
                $this->executeQuery("delete from shoppingcart where id = ?", [$shoppingCart->id]);
                $this->sendOrderConfirmation($createdOrderId, $shoppingCart->userId);
            }
        } catch (\Exception $ex) {
            $this->executeQuery("update product prod inner join shoppingcartitem cartitem on cartitem.productId = prod.id set prod.amountInStock = prod.amountInStock + cartitem.quantity where cartitem.shoppingCartId = ?", [$shoppingCart->id]);

            throw $ex;
        }

        return $result;
    }

    public function getLastCreatedOrderIdForUser(int $userId): int
    {
        return $this->executeQuery("select * from `order` where userId = ? order by id desc limit 1", [$userId], Order::class)[0]->id;
    }

    public function isUserOrder(int $orderId, int $userId): bool
    {
        return $this->executeQuery("select userId from `order` where id = ?", [$orderId])[0]->userId == $userId;
    }

    public function calculateTotalPriceInclTaxWithCouponDiscount(?Coupon $coupon, float $totalPriceInclTax): float
    {
        if (is_null($coupon))
            return $totalPriceInclTax;

        $result = 0;
        switch ($coupon->type) {
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

    public function getOrdersById(int $userId): ?array
    {
        $query = "SELECT * FROM `order` WHERE userId = ? ORDER BY createdOn DESC;";
        $params = [$userId];

        $result = $this->executeQuery($query, $params, Order::class);

        $models = [];
        foreach ($result as $entity) {
            array_push($models, OrderModel::convertToModel($entity));
        }

        if (count($models) === 0)
            return null;
        return $models;
    }

    public function hasBoughtProduct(int $productId, int $userId): bool
    {
        return $this->executeQuery("select exists (select item.id from orderitem item inner join `order` ord on ord.id = item.orderId where item.productId = ? and ord.userId = ? limit 1) as hasBought", [$productId, $userId])[0]->hasBought ?? false;
    }

    private function setOrderTotalAndTax(int &$orderTotal, int &$orderTax, ShoppingCart $shoppingCart, ?Coupon $couponUsed): void
    {
        $orderTotal = (float) $this->executeQuery("select (sum(prod.unitPrice * cartitem.quantity)) as totalPrice from product prod inner join shoppingcartitem cartitem on cartitem.productId = prod.id where cartitem.shoppingCartId = ?", [$shoppingCart->id])[0]->totalPrice;
        $orderTotalInclTaxAndCouponUsed = $this->calculateTotalPriceInclTaxWithCouponDiscount($couponUsed, TaxHelper::calculatePriceIncludingTax($orderTotal));
        $this->executeQuery("update coupon set usageAmount = usageAmount + 1 where id = ?", [$couponUsed->id ?? null]);

        $orderTotal = round(TaxHelper::calculatePriceExcludingTax($orderTotalInclTaxAndCouponUsed), 2);
        $orderTax = round(TaxHelper::calculateTax($orderTotal), 2);
    }

    private function getAddressIdByType(int $userId, AddressType $type): int
    {
        return $this->executeQuery("select id from address where userId = ? and type = ? and active = ?", [$userId, $type->value, 1])[0]->id;
    }

    private function handleCreateOrderItems(int $shoppingCartId, int $orderId): bool
    {
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

    private function sendOrderConfirmation(int $orderId, int $userId): void
    {
        $mailtemplateCustomer = new MailTemplate(MAIL_TEMPLATES . 'OrderConfirmationCustomer.php', [
            'url' => "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}/Account"
        ]);

        $userEmail = $this->executeQuery("select emailAddress from user where id = ?", [$userId])[0]->emailAddress;
        $mail = new Mail($userEmail, "Bestelbevestiging #$orderId", $mailtemplateCustomer, MailFrom::NOREPLY, "no-reply@thesixthstring.store");
        $mail->send();

        $mailtemplateStore = new MailTemplate(MAIL_TEMPLATES . 'OrderConfirmationStore.php', [
            'url' => "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}/ControlPanel/OrderManagement"
        ]);

        $storeMail = new Mail("admin@thesixthstring.store","Nieuwe bestelling #$orderId", $mailtemplateStore, MailFrom::NOREPLY, "no-reply@thesixthstring.store");
        $storeMail->send();
    }

    public function getOrders(string $sortField, SortOrder $sortOrder): ?array
    {
        $query = 'SELECT * FROM `order`';

        $params = [];

        $validSortFields = ["id", "userId", "orderTotal", "orderTax", "couponId", "shippingAddressId", "invoiceAddressId", "paymentStatus", "shippingStatus", "createdOn"];

        if (in_array($sortField, $validSortFields)) {
            $query .= ' ORDER BY ' . $sortField . ' ' . $sortOrder->value;
        } else {
            $query .= ' ORDER BY shippingStatus';
        }

        $result = $this->executeQuery($query, $params, Order::class);

        $orderItemService = Application::resolve(OrderItemService::class);

        $models = [];
        foreach ($result as $entity) {
            // array_push($models, OrderModel::convertToModel($entity));

            $model = new OrderManagementOrderModel();

            $model->id = $entity->id;
            $model->orderItems = $orderItemService->getOrderItemByOrderId($entity->id);
            $itemCount = 0;
            foreach ($model->orderItems as $orderItem) {
                $itemCount += $orderItem->quantity;
            }
            $model->orderItemsCount = $itemCount;
            $model->orderTotal = $entity->orderTotal;
            $model->orderTax = $entity->orderTax;
            $model->shippingAddress = Application::resolve(AddressService::class)->getAddressByUserId($entity->userId, AddressType::Shipping->value);
            $model->paymentStatus = MolliePaymentStatus::from($entity->paymentStatus);
            $model->shippingStatus = ShippingStatus::from($entity->shippingStatus);
            $model->createdOn = new \DateTime($entity->createdOn);

            $models[] = $model;
        }

        if (count($models) === 0) {
            return null;
        }
        return $models;
    }

    public function getManagementOrderById(int $id): ?OrderManagementOrderModel
    {
        $query = 'SELECT * FROM `order` WHERE id = ?';

        $params = [$id];

        $result = $this->executeQuery($query, $params, Order::class);

        if ($result === null) {
            return null;
        }

        $orderItemService = Application::resolve(OrderItemService::class);

        $model = new OrderManagementOrderModel();

        $model->id = $result[0]->id;
        $model->orderItems = $orderItemService->getOrderItemByOrderId($result[0]->id);
        $itemCount = 0;
        foreach ($model->orderItems as $orderItem) {
            $itemCount += $orderItem->quantity;
        }
        $model->orderItemsCount = $itemCount;
        $model->orderTotal = $result[0]->orderTotal;
        $model->orderTax = $result[0]->orderTax;
        $model->shippingAddress = Application::resolve(AddressService::class)->getAddressByUserId($result[0]->userId, AddressType::Shipping->value);
        $model->paymentStatus = MolliePaymentStatus::from($result[0]->paymentStatus);
        $model->shippingStatus = ShippingStatus::from($result[0]->shippingStatus);
        $model->createdOn = new \DateTime($result[0]->createdOn);

        return $model;
    }

    public function setShippingStatus(int $id, ShippingStatus $shippingStatus): bool
    {
        $query = 'UPDATE `order` SET shippingStatus = ? WHERE id = ?';

        $params = [$shippingStatus->value, $id];

        $result = $this->executeQuery($query, $params);

        dumpDie($result);

        return $result;
    }
}