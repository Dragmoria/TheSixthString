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
}
