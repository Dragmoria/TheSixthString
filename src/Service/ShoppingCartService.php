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
        $query = "select * from shoppingcart where ";
        $params = [];

        if(!is_null($userId)) {
            //user is logged in, fetch the shoppingcart for this user
            $query .= "userId = ?";
            $params[] = $userId;
        } else {
            //user is not logged in, fetch the shoppingcart by the guid stored in the session
            $query .= "sessionUserGuid = ?";
            $params[] = $sessionUserGuid;
        }

        //TODO: als er een userId aanwezig is, ook checken of er voor de sessionUserGuid een winkelwagen aanwezig is; zo ja, dan deze producten overzetten naar winkelwagen voor userId?

        $shoppingCartEntity = $this->getShoppingCartByUser($userId, $sessionUserGuid);
        if(is_null($shoppingCartEntity)) return null;

        //TODO: onderstaande wijkt af van het domeinmodel/ERD! gewoon null teruggeven, niets aanmaken (nog controleren in FO!)
//        if(is_null($shoppingCartEntity)) {
//            $currentDateTime = ((array)new \DateTime())['date'];
//            $this->executeQuery("insert into shoppingcart (userId, sessionUserGuid, createdOn, modifiedOn) values (?,?,?,?)", [$userId, $sessionUserGuid, $currentDateTime, $currentDateTime]);
//            $shoppingCartEntity = $this->executeQuery($query, $params, ShoppingCart::class)[0];
//            return ShoppingCartModel::convertToModel($shoppingCartEntity);
//        }

        $shoppingCartModel = ShoppingCartModel::convertToModel($shoppingCartEntity);

        $this->fillModelWithShoppingCartItems($shoppingCartModel, $shoppingCartEntity);

        return $shoppingCartModel;
    }

    public function deleteItem(?int $userId, string $sessionUserGuid, int $id): bool {
        $itemQuery = "delete item from shoppingcartitem item inner join shoppingcart cart on cart.id = item.shoppingCartId where (cart.userId = ? or cart.sessionUserGuid = ?) and item.id = ?";
        $result = $this->executeQuery($itemQuery, [$userId, $sessionUserGuid, $id]);

        $cartCleanupQuery = "delete cart FROM shoppingcart cart where not exists (select * from shoppingcartitem where shoppingCartId = cart.id and (cart.userId = ? or cart.sessionUserGuid = ?))";
        $result &= $this->executeQuery($cartCleanupQuery, [$userId, $sessionUserGuid]);

        return $result;
    }

    public function addItem(?int $userId, string $sessionUserGuid, int $productId, int $quantity): bool {
        //TODO: wat als er al en winkelwagentje bestaat en er al een shoppingcartitem voor dit product bestaat?

        $shoppingCartEntity = $this->getShoppingCartByUser($userId, $sessionUserGuid);
        if(is_null($shoppingCartEntity)) {
            $currentDateTime = ((array)new \DateTime())['date'];
            $this->executeQuery("insert into shoppingcart (userId, sessionUserGuid, createdOn, modifiedOn) values (?,?,?,?)", [$userId, $sessionUserGuid, $currentDateTime, $currentDateTime]);
            $shoppingCartEntity = $this->getShoppingCartByUser($userId, $sessionUserGuid);
        }

        return $this->executeQuery("insert into shoppingcartitem (shoppingCartId, productId, quantity) values (?,?,?)", [$shoppingCartEntity->id, $productId, $quantity]);
    }

    private function fillModelWithShoppingCartItems(ShoppingCartModel &$model, ShoppingCart $entity): void {
        $shoppingCartItemEntities = $this->executeQuery("select * from shoppingcartitem where shoppingCartId = ?", [$entity->id], ShoppingCartItem::class);
        foreach($shoppingCartItemEntities as $shoppingCartItemEntity) {
            $shoppingCartItemModel = ShoppingCartItemModel::convertToModel($shoppingCartItemEntity);
            $productEntity = $this->executeQuery("select id, name, sku, unitPrice, media from product where id = ?", [$shoppingCartItemEntity->productId], Product::class)[0];
            $shoppingCartItemModel->product = ProductModel::convertToModel($productEntity);
            $shoppingCartItemModel->calculateTotalPriceIncludingTax();

            $model->items[] = $shoppingCartItemModel;
        }

        $model->getTotalPriceIncludingTax();
    }

    private function getShoppingCartByUser(?int $userId, string $sessionUserGuid): ?ShoppingCart {
        $query = "select * from shoppingcart where ";
        $params = [];

        if(!is_null($userId)) {
            //user is logged in, fetch the shoppingcart for this user
            $query .= "userId = ?";
            $params[] = $userId;
        } else {
            //user is not logged in, fetch the shoppingcart by the guid stored in the session
            $query .= "sessionUserGuid = ?";
            $params[] = $sessionUserGuid;
        }

        //TODO: als er een userId aanwezig is, ook checken of er voor de sessionUserGuid een winkelwagen aanwezig is; zo ja, dan deze producten overzetten naar winkelwagen voor userId?

        return $this->executeQuery($query, $params, ShoppingCart::class)[0] ?? null;
    }
}