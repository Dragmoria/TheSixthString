<?php

namespace Lib\Helpers;

use Lib\Constants;

class TaxHelper {
    public static function calculatePriceIncludingTax(float $price): float {
        return $price * (1 + Constants::TAX_PERCENTAGE / 100);
    }
}