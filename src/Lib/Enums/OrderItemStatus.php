<?php

namespace Lib\Enums;

enum OrderItemStatus: int {
    case Sent = 0;
    case Returned = 1;

    public function toString()
    {
        switch ($this->value) {
            case 0:
                return "Sent";
            case 1:
                return "Returned";
        }
    }

}