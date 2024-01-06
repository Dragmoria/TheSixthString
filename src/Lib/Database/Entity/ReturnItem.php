<?php

namespace Lib\Database\Entity;

use Lib\Enums\OrderItemStatus;

class ReturnItem extends SaveableObject {
    public function __construct() {
        parent::__construct("returnitem");
    }

    public int $returnOrderId = 0;
    public int $productId = 0;
    public float $unitPrice = 0;
    public int $quantity = 0;
    public int $status = OrderItemStatus::Sent->value;
}