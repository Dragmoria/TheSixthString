<?php

namespace Lib\Enums;

enum Gender: int
{
    case Unknown = 0;
    case Female = 1;
    case Male = 2;

    public function toString()
    {
        switch ($this->value) {
            case 0:
                return "Unknown";
            case 1:
                return "Female";
            case 2:
                return "Male";
            default:
                return "Unknown";
        }
    }

    public function toStringTranslate()
    {
        switch ($this->value) {
            case 0:
                return "Onbekend";
            case 1:
                return "Mevrouw";
            case 2:
                return "De heer";
            default:
                return "Onbekend";
        }
    }

    public static function fromString(string $from)
    {
        switch (strtolower($from)) {
            case 'unknown':
                return self::Unknown;
            case 'female':
                return self::Female;
            case 'male':
                return self::Male;
            default:
                throw new \InvalidArgumentException("Invalid gender: $from");
        }
    }
}
