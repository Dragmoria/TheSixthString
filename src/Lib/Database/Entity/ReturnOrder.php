<?php

namespace Lib\Database\Entity;

use Lib\Enums\ShippingStatus;

class ReturnOrder extends SaveableObject {
    public function __construct() {
        parent::__construct("`returnorder`");
    }

    public ?int $orderId = 0;
    public float $returnTotal = 0;
    public int $shippingStatus = ShippingStatus::AwaitingShipment->value;
    public string $createdOn = "";
}