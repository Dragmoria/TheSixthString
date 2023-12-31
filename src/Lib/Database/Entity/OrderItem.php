<?php

namespace Lib\Database\Entity;

use Lib\Enums\OrderItemStatus;

class OrderItem extends SaveableObject {
    public function __construct() {
        parent::__construct("orderitem");
    }

    public int $orderId = 0;
    public int $productId = 0;
    public float $unitPrice = 0; //without tax; multiply before showing to the customer by using Constants::TAX_PERCENTAGE
    public int $quantity = 0;
    public int $status = OrderItemStatus::Sent->value;
}