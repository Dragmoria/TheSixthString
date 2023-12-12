<?php

namespace Lib\Database\Entity;

class PaymentProvider extends SaveableObject {
    public function __construct() {
        parent::__construct("paymentprovider");
    }

    public string $name = "";
    public string $apiKey = "";
    public string $apiSecret = "";
    public bool $active = false;
}