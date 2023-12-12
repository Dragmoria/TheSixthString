<?php

namespace Lib\Enums;

enum Role: int
{
    case Customer = 0;
    case Staff = 1;
    case Analyst = 2;
    case Manager = 3;
    case Admin = 4;

    public function hasRightsOf(Role $role): bool
    {
        return $this->value >= $role->value;
    }

    public function toString(): string
    {
        switch ($this->value) {
            case 0:
                return "Klant";
            case 1:
                return "Medewerker";
            case 2:
                return "Analyst";
            case 3:
                return "Manager";
            case 4:
                return "Admin";
            default:
                return "Unknown";
        }
    }

    public static function fromString(string $from)
    {
        switch (strtolower($from)) {
            case 'customer':
                return self::Customer;
            case 'staff':
                return self::Staff;
            case 'analyst':
                return self::Analyst;
            case 'manager':
                return self::Manager;
            case 'admin':
                return self::Admin;
            default:
                throw new \InvalidArgumentException("Invalid gender: $from");
        }
    }
}
