<?php

namespace Lib\Enums;

enum Role: int {
    case Customer = 0;
    case Analyst = 1;
    case Manager = 2;
    case Admin = 3;
}