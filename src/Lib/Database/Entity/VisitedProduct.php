<?php

namespace Lib\Database\Entity;

class VisitedProduct extends SaveableObject {
    public function __construct() {
        parent::__construct("visitedproduct");
    }

    public int $productId = 0;
    public string $date = "";
    public string $sessionUserGuid = "";

    //NOTE: this is not a column, it's used in getVisitedProductsForDateRange() to get the amount of unique visitors for each product on a certain date!
    public int $visitors = 0;
}