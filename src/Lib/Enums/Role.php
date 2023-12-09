<?php

namespace Lib\Enums;

enum Role: int {
    case Customer = 0;
    case Analyst = 1;
    case Manager = 2;
    case Admin = 3;

    public function hasRightsOf(Role $role): bool {
        return $this->value >= $role->value;
    }
}