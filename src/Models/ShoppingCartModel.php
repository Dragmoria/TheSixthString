<?php

namespace Models;

use Lib\Database\Entity\ShoppingCart;

class ShoppingCartModel {
    public array $items = array();
    public float $totalPriceIncludingTax = 0;

    public static function convertToModel(?ShoppingCart $entity): ?ShoppingCartModel {
        if($entity->isEmptyObject()) return null;

        return new ShoppingCartModel();
    }

    public function getTotalPriceIncludingTax(): void {
        foreach($this->items as $shoppingCartItem) {
            $this->totalPriceIncludingTax += $shoppingCartItem->totalPriceIncludingTax;
        }
    }
}