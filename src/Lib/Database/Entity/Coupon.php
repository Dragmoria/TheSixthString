<?php

namespace Lib\Database\Entity;

use Lib\Enums\CouponType;

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
    public int $type = CouponType::Amount->value;
}