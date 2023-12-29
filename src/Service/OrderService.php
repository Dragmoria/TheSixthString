<?php

namespace Service;

use Lib\Database\Entity\Coupon;
use Lib\Database\Entity\Order;
use Lib\Database\Entity\ShoppingCart;
use Lib\Enums\AddressType;
use Lib\Enums\OrderItemStatus;
use Lib\Enums\PaymentStatus;
use Lib\Enums\ShippingStatus;
use Lib\Helpers\TaxHelper;

class OrderService extends BaseDatabaseService {
    public function createOrderWithOrderItems(ShoppingCart $shoppingCart, ?Coupon $couponUsed): bool {
        //TODO: (niet vergeten: bij aanklikken 'Bestellen' ook een redirect naar login als de gebruiker nog niet is ingelogd!)
        // laatste controle of er echt wel genoeg voorraad is, dit bij het laden van de pagina doen!
        // V product.amountInStock aanpassen met aantal uit de bestelling
        // V Order maken, OrderItems maken
        // V ShoppingCart verwijderen(, vanuit controller ShoppingCartService aanroepen?)
        // e-mail met bestellingsoverzicht sturen, zowel naar klant als naar webshop

        $allProductsAvailable = $this->executeQuery("select (count(prod.id) = 0) as allAvailable from product prod inner join shoppingcartitem cartitem on cartitem.productId = prod.id where (cartitem.quantity > prod.amountInStock or prod.active = ?) and cartitem.shoppingCartId = ?", [0, $shoppingCart->id])[0]->allAvailable;
        if(!(bool)$allProductsAvailable) {
            return false;
        }

        try {
            $this->executeQuery("update product prod inner join shoppingcartitem cartitem on cartitem.productId = prod.id set prod.amountInStock = prod.amountInStock - cartitem.quantity where cartitem.shoppingCartId = ?", [$shoppingCart->id]);

            //TODO! totaal en verwerken coupon
            $orderTotal = 10;
            $orderTax = TaxHelper::calculateTax($orderTotal);

            $shippingAddressId = $this->getAddressIdByType($shoppingCart->userId, AddressType::Shipping);
            $invoiceAddressId = $this->getAddressIdByType($shoppingCart->userId, AddressType::Invoice);
            $currentDateTime = ((array)new \DateTime())['date'];

            $createOrderQuery = "insert into `order` (userId, orderTotal, orderTax, couponId, shippingAddressId, invoiceAddressId, paymentStatus, shippingStatus, createdOn) values (?,?,?,?,?,?,?,?,?)";
            $result = $this->executeQuery($createOrderQuery, [$shoppingCart->userId, $orderTotal, $orderTax, $couponUsed->id ?? null, $shippingAddressId, $invoiceAddressId, PaymentStatus::AwaitingPayment->value, ShippingStatus::AwaitingShipment->value, $currentDateTime]);
            $createdOrderEntity = $this->executeQuery("select * from `order` where userId = ? order by id desc limit 1", [$shoppingCart->userId], Order::class)[0];

            $result &= $this->handleCreateOrderItems($shoppingCart->id, $createdOrderEntity->id);

            if($result) {
                $this->executeQuery("delete from shoppingcart where id = ?", [$shoppingCart->id]);
            }
        } catch(\Exception $ex) {
            $this->executeQuery("update product prod inner join shoppingcartitem cartitem on cartitem.productId = prod.id set prod.amountInStock = prod.amountInStock + cartitem.quantity where cartitem.shoppingCartId = ?", [$shoppingCart->id]);

            throw $ex;
        }

        return $result;
    }

    private function getAddressIdByType(int $userId, AddressType $type): int {
        return $this->executeQuery("select id from address where userId = ? and type = ?", [$userId, $type->value])[0]->id;
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
}