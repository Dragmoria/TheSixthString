<?php

namespace Lib\Enums;

enum AddressType: int {
    case Invoice = 0;
    case Shipping = 1;
}