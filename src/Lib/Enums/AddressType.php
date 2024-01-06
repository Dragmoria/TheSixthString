<?php

namespace Lib\Enums;

enum AddressType: int {
    case Invoice = 0;
    case Shipping = 1;

    public function toString(): string {
        switch($this->value) {
            case AddressType::Invoice->value:
                return "Factuuradres";
            case AddressType::Shipping->value:
                return "Bezorgadres";
            default:
                throw new \InvalidArgumentException("Unknown addresstype " . $this->value);
        }
    }
}