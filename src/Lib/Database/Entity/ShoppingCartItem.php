<?php

namespace Lib\Database\Entity;

class ShoppingCartItem extends SaveableObject {
    public function __construct() {
        $this->tableName = "shoppingcartitem";
    }

    public int $shoppingCartId = 0;
    public int $productId = 0;
    public int $quantity = 0;
}