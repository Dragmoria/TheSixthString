<?php

namespace Lib\Database\Entity;

use Lib\Enums\PaymentStatus;
use Lib\Enums\ShippingStatus;

class Order extends SaveableObject {
    public function __construct() {
        parent::__construct("`order`"); //order is a keyword, so it's not recognized without the backticks
    }

    public ?int $userId = null;
    public float $orderTotal = 0; //without tax; add $this->>orderTax to show the full order total
    public float $orderTax = 0;
    public ?int $couponId = null;
    public ?int $shippingAddressId = null;
    public ?int $invoiceAddressId = null;
    public int $paymentStatus = PaymentStatus::AwaitingPayment->value;
    public int $shippingStatus = ShippingStatus::AwaitingShipment->value;
    public string $createdOn = "";
}