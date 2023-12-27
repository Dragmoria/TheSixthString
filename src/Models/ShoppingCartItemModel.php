<?php

namespace Models;

use Lib\Database\Entity\ShoppingCartItem;

class ShoppingCartItemModel {
    public int $id;
    public ProductModel $product;
    public int $quantity;
    public float $totalPriceIncludingTax;

    public static function convertToModel(?ShoppingCartItem $entity): ?ShoppingCartItemModel {
        if($entity->isEmptyObject()) return null;

        $model = new ShoppingCartItemModel();
        $model->id = $entity->id;
        $model->quantity = $entity->quantity;

        return $model;
    }

    public function calculateTotalPriceIncludingTax(): void {
        $this->totalPriceIncludingTax = $this->product->unitPrice * $this->quantity;
    }
}