<?php

namespace Lib\Helpers;

use Lib\Constants;

class TaxHelper {
    public static function calculatePriceIncludingTax(float $priceExclTax): float {
        return $priceExclTax * (1 + Constants::TAX_PERCENTAGE / 100);
    }

    public static function calculatePriceExcludingTax(float $priceInclTax): float {
        return $priceInclTax / (1 + Constants::TAX_PERCENTAGE / 100);
    }
}