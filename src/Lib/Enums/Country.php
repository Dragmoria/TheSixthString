<?php

namespace Lib\Enums;

enum Country: int
{
    case Netherlands = 0;
    case Belgium = 1;
    case Luxembourg = 2;

    public function toString()
    {
        switch ($this->value) {
            case 0:
                return "Netherlands";
            case 1:
                return "Belgium";
            case 2:
                return "Luxembourg";
            default:
                return "Netherlands";
        }
    }

    public function toStringTranslate()
    {
        switch ($this->value) {
            case 0:
                return "Nederland";
            case 1:
                return "België";
            case 2:
                return "Luxemburg";
            default:
                return "Nederland";
        }
    }

    public static function fromString(string $from)
    {
        switch (strtolower($from)) {
            case 'netherlands':
                return self::Netherlands;
            case 'belgium':
                return self::Belgium;
            case 'luxembourg':
                return self::Luxembourg;
            default:
                throw new \InvalidArgumentException("Invalid country: $from");
        }
    }
}
