<?php

namespace Lib\Enums;

enum PaymentStatus: int {
    case AwaitingPayment = 0;
    case Declined = 1;
    case Fulfilled = 2;
    
    public function toString()
    {
        switch ($this->value) {
            case 0:
                return "AwaitingPayment";
            case 1:
                return "Declined";
            case 2:
                return "Fulfilled";
        }
    }

}