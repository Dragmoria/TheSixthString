<?php

namespace Lib\Enums;

enum PaymentMethod: int {
    case Ideal = 0;
    case Paypal = 1;
    case PayLater = 2;

    public function toString(): string
    {
        switch ($this->value) {
            case PaymentMethod::Ideal->value:
                return "iDeal";
            case PaymentMethod::Paypal->value:
                return "PayPal";
            case PaymentMethod::PayLater->value:
                return "Achteraf betalen";
            default:
                throw new \InvalidArgumentException("Unknown paymentmethod " . $this->value);
        }
    }

    public static function fromString(string $from)
    {
        switch ($from) {
            case self::Ideal->name:
                return self::Ideal;
            case self::Paypal->name:
                return self::Paypal;
            case self::PayLater->name:
                return self::PayLater;
            default:
                throw new \InvalidArgumentException("Invalid paymentmethod: $from");
        }
    }
}