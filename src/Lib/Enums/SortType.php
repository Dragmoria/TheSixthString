<?php

namespace Lib\Enums;

enum SortType: int {
    case PriceAsc = 0;
    case PriceDesc = 1;
    case NameAsc = 2;
    case NameDesc = 3;

    public function toString(): string
    {
        switch ($this->value) {
            case SortType::PriceAsc->value:
                return "Prijs oplopend";
            case SortType::PriceDesc->value:
                return "Prijs aflopend";
            case SortType::NameAsc->value:
                return "Naam A-Z";
            case SortType::NameDesc->value:
                return "Naam Z-A";
            default:
                throw new \InvalidArgumentException("Unknown sorttype " . $this->value);
        }
    }

    public static function fromString(string $from)
    {
        switch ($from) {
            case self::PriceAsc->name:
                return self::PriceAsc;
            case self::PriceDesc->name:
                return self::PriceDesc;
            case self::NameAsc->name:
                return self::NameAsc;
            case self::NameDesc->name:
                return self::NameDesc;
            default:
                throw new \InvalidArgumentException("Invalid sort type: $from");
        }
    }
}