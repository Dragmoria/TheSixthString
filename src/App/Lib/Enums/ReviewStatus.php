<?php

namespace Lib\Enums;

enum ReviewStatus: int {
    case ToBeReviewed = 0;
    case Accepted = 1;
    case Denied = 2;
}