<?php

namespace Lib\Enums;

enum CouponType: int
{
    case Amount = 0;
    case Percentage = 1;

    public function toString($lang = "en")
    {
        if ($lang === "nl") {
            switch ($this->value) {
                case 0:
                    return "Bedrag";
                case 1:
                    return "Percentage";
                default:
                    return "Unknown";
            }
        } else if ($lang === "en") {
            switch ($this->value) {
                case 0:
                    return "Amount";
                case 1:
                    return "Percentage";
                default:
                    return "Unknown";
            }
        }
    }

    public static function fromString(string $from)
    {
        switch (strtolower($from)) {
            case 'amount':
                return self::Amount;
            case 'percentage':
                return self::Percentage;
            default:
                throw new \InvalidArgumentException("Invalid coupon type: $from");
        }
    }
}
