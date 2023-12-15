<?php

namespace Lib\Enums;

enum OrderItemStatus: int {
    case Sent = 0;
    case Returned = 1;
}