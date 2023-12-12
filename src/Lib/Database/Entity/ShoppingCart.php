<?php

namespace Lib\Database\Entity;

class ShoppingCart extends SaveableObject {
    public function __construct() {
        $this->tableName = "shoppingcart";
    }

    public ?int $userId = null;
    public string $sessionUserGuid = "";
    public string $createdOn = "";
    public string $modifiedOn = "";
}