<?php

namespace Lib\Enums;

enum ShippingStatus: int
{
    case AwaitingShipment = 0;
    case Delivered = 1;
    case Cancelled = 2;

    public function toString()
    {
        switch ($this->value) {
            case 0:
                return "AwaitingShipment";
            case 1:
                return "Delivered";
            case 2:
                return "Canceled";
        }
    }
}