<?php

namespace Lib\Enums;

enum ReviewStatus: int
{
    case ToBeReviewed = 0;
    case Accepted = 1;
    case Denied = 2;

    public function toString(): string
    {
        switch ($this->value) {
            case 0:
                return "To be reviewed";
            case 1:
                return "Accepted";
            case 2:
                return "Denied";
            default:
                return "Unknown";
        }
    }
}