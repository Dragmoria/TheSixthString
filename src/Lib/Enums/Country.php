<?php

namespace Lib\Enums;

enum Country: int
{
    case Netherlands = 0;
    case Belgium = 1;
    case Luxembourgh = 2;

    public function toString()
    {
        switch ($this->value) {
            case 0:
                return "Netherlands";
            case 1:
                return "Belgium";
            case 2:
                return "Luxembourgh";
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
            case 'Netherlands':
                return self::Netherlands;
            case 'Belgium':
                return self::Belgium;
            case 'Luxembourgh':
                return self::Luxembourgh;
            default:
                throw new \InvalidArgumentException("Invalid country: $from");
        }
    }
}
