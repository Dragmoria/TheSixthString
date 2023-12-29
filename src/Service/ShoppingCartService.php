<?php

namespace Service;

use Cassandra\Date;
use Lib\Database\Entity\Product;
use Lib\Database\Entity\ShoppingCart;
use Lib\Database\Entity\ShoppingCartItem;
use Models\ProductModel;
use Models\ShoppingCartItemModel;
use Models\ShoppingCartModel;

class ShoppingCartService extends BaseDatabaseService {
    public function getShoppingCartContent(?int $userId, string $sessionUserGuid): ?ShoppingCartModel {
        $shoppingCartEntity = $this->getShoppingCartByUser($userId, $sessionUserGuid);
        if(is_null($shoppingCartEntity)) return null;

        $shoppingCartModel = ShoppingCartModel::convertToModel($shoppingCartEntity);

        $this->fillModelWithShoppingCartItems($shoppingCartModel, $shoppingCartEntity);

        return $shoppingCartModel;
    }

    public function deleteItem(?int $userId, string $sessionUserGuid, int $id): bool {
        $itemQuery = "delete item from shoppingcartitem item inner join shoppingcart cart on cart.id = item.shoppingCartId where item.id = ? and ";
        $itemParams = [$id];
        $this->constructUserIdSessionUserGuidQueryString($userId, $sessionUserGuid, $itemQuery, $itemParams);
        $result = $this->executeQuery($itemQuery, $itemParams);

        $cartCleanupQuery = "delete cart FROM shoppingcart cart where not exists (select * from shoppingcartitem where shoppingCartId = cart.id and ";
        $cartCleanupParams = [];
        $this->constructUserIdSessionUserGuidQueryString($userId, $sessionUserGuid, $cartCleanupQuery, $cartCleanupParams);
        $cartCleanupQuery .= ")";

        $result &= $this->executeQuery($cartCleanupQuery, $cartCleanupParams);

        return $result;
    }

    public function changeQuantity(?int $userId, $sessionUserGuid, int $productId, int $quantity): bool {
        $query = "update shoppingcartitem item inner join shoppingcart cart on cart.id = item.shoppingCartId set item.quantity = ? where productId = ? and ";
        $params = [$quantity, $productId];

        $this->constructUserIdSessionUserGuidQueryString($userId, $sessionUserGuid, $query, $params);

        return $this->executeQuery($query, $params);
    }

    public function addItem(?int $userId, string $sessionUserGuid, int $productId, int $quantity): bool {
        $shoppingCartEntity = $this->getShoppingCartByUser($userId, $sessionUserGuid);
        if(is_null($shoppingCartEntity)) {
            $currentDateTime = ((array)new \DateTime())['date'];
            $this->executeQuery("insert into shoppingcart (userId, sessionUserGuid, createdOn, modifiedOn) values (?,?,?,?)", [$userId, $sessionUserGuid, $currentDateTime, $currentDateTime]);
            $shoppingCartEntity = $this->getShoppingCartByUser($userId, $sessionUserGuid);
        }

        return $this->executeAddOrUpdateShoppingCartItemQuery($shoppingCartEntity, $productId, $quantity);
    }

    public function mergeCarts(int $userId, string $sessionUserGuid): void {
        $cartByUserId = $this->executeQuery("select * from shoppingcart where userId = ?", [$userId], ShoppingCart::class)[0] ?? null;
        $cartBySessionUserGuid = $this->executeQuery("select * from shoppingcart where sessionUserGuid = ?", [$sessionUserGuid], ShoppingCart::class)[0] ?? null;

        if(is_null($cartByUserId) && !is_null($cartBySessionUserGuid)) {
            $this->executeQuery("update shoppingcart set userId = ? where sessionUserGuid = ?", [$userId, $sessionUserGuid]);
        } else if(!is_null($cartByUserId) && !is_null($cartBySessionUserGuid) && $cartByUserId->id != $cartBySessionUserGuid->id) {
            $itemsForCartByUserGuid = $this->executeQuery("select * from shoppingcartitem where shoppingCartId = ?", [$cartBySessionUserGuid->id], ShoppingCartItem::class);
            foreach($itemsForCartByUserGuid as $item) {
                $this->executeAddOrUpdateShoppingCartItemQuery($cartByUserId, $item->productId, $item->quantity);
            }

            $this->executeQuery("delete from shoppingcart where id = ?", [$cartBySessionUserGuid->id]);
            $this->executeQuery("update shoppingcart set sessionUserGuid = ? where id = ?", [$sessionUserGuid, $cartByUserId->id]);
        }
    }

    public function getShoppingCartByUser(?int $userId, string $sessionUserGuid): ?ShoppingCart {
        $query = "select * from shoppingcart where ";
        $params = [];

        $this->constructUserIdSessionUserGuidQueryString($userId, $sessionUserGuid, $query, $params);

        return $this->executeQuery($query, $params, ShoppingCart::class)[0] ?? null;
    }

    private function executeAddOrUpdateShoppingCartItemQuery(ShoppingCart $shoppingCartEntity, int $productId, int $quantity): bool {
        $shoppingCartItemExists = $this->executeQuery("select (count(id) > 0) as itemExists from shoppingcartitem where shoppingCartId = ? and productId = ?", [$shoppingCartEntity->id, $productId])[0]->itemExists;
        if((bool)$shoppingCartItemExists) {
            return $this->executeQuery("update shoppingcartitem item inner join product prod on prod.id = item.productId set quantity = least(prod.amountInStock, quantity + ?) where shoppingCartId = ? and productId = ?", [$quantity, $shoppingCartEntity->id, $productId]);
        }

        return $this->executeQuery("insert into shoppingcartitem (shoppingCartId, productId, quantity) values (?,?,?)", [$shoppingCartEntity->id, $productId, $quantity]);
    }

    private function fillModelWithShoppingCartItems(ShoppingCartModel &$model, ShoppingCart $entity): void {
        $shoppingCartItemEntities = $this->executeQuery("select * from shoppingcartitem where shoppingCartId = ?", [$entity->id], ShoppingCartItem::class);
        foreach($shoppingCartItemEntities as $shoppingCartItemEntity) {
            $shoppingCartItemModel = ShoppingCartItemModel::convertToModel($shoppingCartItemEntity);

            $productEntity = $this->executeQuery("select id, name, sku, unitPrice, amountInStock, media from product where id = ?", [$shoppingCartItemEntity->productId], Product::class)[0];
            $shoppingCartItemModel->product = ProductModel::convertToModel($productEntity);
            $shoppingCartItemModel->calculateTotalPriceIncludingTax();

            $model->items[] = $shoppingCartItemModel;
        }

        $model->getTotalPriceIncludingTax();
    }

    private function constructUserIdSessionUserGuidQueryString(?int $userId, string $sessionUserGuid, string &$query, array &$params): void {
        if(!is_null($userId)) {
            //user is logged in, fetch the shoppingcart for this user
            $query .= "userId = ?";
        } else {
            //user is not logged in, fetch the shoppingcart by the guid stored in the session
            $query .= "sessionUserGuid = ?";
        }

        $params[] = $userId ?? $sessionUserGuid;
    }
}