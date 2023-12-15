<?php

namespace Lib\Database\Entity;

class Coupon extends SaveableObject {
    public function __construct() {
        parent::__construct("coupon");
    }

    public string $name = "";
    public string $code = "";
    public float $value = 0;
    public string $startDate = "";
    public ?string $endDate = null;
    public int $usageAmount = 0;
    public ?int $maxUsageAmount = null;
    public bool $active = false;
    public int $type = 0; //default is CouponType::Amount (= 0)
}