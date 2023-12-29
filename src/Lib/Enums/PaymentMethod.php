<?php

namespace Lib\Enums;

enum PaymentMethod: int {
    case Ideal = 0;
    case Paypal = 1;
    case Manual = 2;
}