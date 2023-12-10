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

    public function toString(): string {
        switch($this->value) {
            case 0:
                return "Klant";
            case 1:
                return "Analyst";
            case 2:
                return "Manager";
            case 3:
                return "Admin";
            default:
                return "Unknown";
        }
    }
}