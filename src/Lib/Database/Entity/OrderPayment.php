<?php

namespace Lib\Database\Entity;

class OrderPayment extends SaveableObject {
    public function __construct() {
        $this->tableName = "orderpayment";
    }

    public int $orderId = 0;
    public int $method = 0; //default is PaymentMethod::Ideal (= 0)
    public ?string $paymentDate = null;
}