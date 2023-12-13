<?php

namespace Lib\Database\Entity;

class VisitedProduct extends SaveableObject {
    public function __construct() {
        parent::__construct("visitedproduct");
    }

    public int $productId = 0;
    public string $date = "";
    public string $sessionUserGuid = "";
}