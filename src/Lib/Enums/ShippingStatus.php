<?php

namespace Lib\Enums;

enum ShippingStatus: int {
    case AwaitingShipment = 0;
    case Delivered = 1;
    case Cancelled = 2;
}