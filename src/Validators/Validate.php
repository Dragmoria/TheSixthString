<?php

namespace Validators;

use Lib\Enums\Gender;
use Lib\Enums\Role;

class Validate
{
    public static function email(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function password(string $password): bool
    {
        return strlen($password) >= 8;
    }

    public static function notEmpty(string $value): bool
    {
        return strlen(trim($value)) > 0;
    }

    public static function genderString(string $gender)
    {
        // check if i can make an Enum gender from this $gender string
        try {
            Gender::fromString($gender);
            return true;
        } catch (\InvalidArgumentException $e) {
            return false;
        }
    }

    public static function dateString(string $date)
    {
        try {
            new \DateTime($date);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function roleString(string $role)
    {
        try {
            Role::fromString($role);
            return true;
        } catch (\InvalidArgumentException $e) {
            return false;
        }
    }
}
