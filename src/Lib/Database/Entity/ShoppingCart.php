<?php

namespace Lib\Database\Entity;

class ShoppingCart extends SaveableObject {
    public function __construct() {
        parent::__construct("shoppingcart");
    }

    public ?int $userId = null;
    public string $sessionUserGuid = "";
    public string $createdOn = "";
    public string $modifiedOn = "";
}