<?php

namespace Lib\Database\Entity;

use Lib\Enums\PaymentMethod;

class OrderPayment extends SaveableObject {
    public function __construct() {
        parent::__construct("orderpayment");
    }

    public int $orderId = 0;
    public int $method = PaymentMethod::Ideal->value;
    public ?string $paymentId = null;
    public ?string $paymentDate = null;
}