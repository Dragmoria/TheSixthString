<?php

namespace Lib\Database\Entity;

class Order extends SaveableObject {
    public function __construct() {
        parent::__construct("`order`"); //order is a keyword, so it's not recognized without the backticks
    }

    public int $userId = 0;
    public float $orderTotal = 0; //without tax; add $this->>orderTax to show the full order total
    public float $orderTax = 0;
    public ?int $couponId = null;
    public int $shippingAddressId = 0;
    public int $invoiceAddressId = 0;
    public int $paymentStatus = 0; //default is PaymentStatus::AwaitingPayment (= 0)
    public int $shippingStatus = 0; //default is ShippingStatus::AwaitingShipment (= 0)
    public string $createdOn = "";
}