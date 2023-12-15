<?php

namespace Lib\Enums;

enum PaymentStatus: int {
    case AwaitingPayment = 0;
    case Declined = 1;
    case Fulfilled = 2;
}