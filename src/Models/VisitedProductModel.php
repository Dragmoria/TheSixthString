<?php

namespace Models;

class VisitedProductModel {
    public int $visitors;
    public int $orderAmount;
    public int $totalAmount;
    public float $ratioUniqueOrders;
    public float $ratioTotalAmount;
    public ProductModel $product;
}