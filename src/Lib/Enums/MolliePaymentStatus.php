<?php

namespace Lib\Enums;

enum MolliePaymentStatus: int
{
    case Open = 0;
    case Canceled = 1;
    case Pending = 2;
    case Authorized = 3;
    case Expired = 4;
    case Failed = 5;
    case Paid = 6;

    public static function fromString(string $from)
    {
        switch ($from) {
            case strtolower(self::Open->name):
                return self::Open;
            case strtolower(self::Canceled->name):
                return self::Canceled;
            case strtolower(self::Pending->name):
                return self::Pending;
            case strtolower(self::Authorized->name):
                return self::Authorized;
            case strtolower(self::Expired->name):
                return self::Expired;
            case strtolower(self::Failed->name):
                return self::Failed;
            case strtolower(self::Paid->name):
                return self::Paid;
            default:
                throw new \InvalidArgumentException("Invalid mollie payment status: $from");
        }
    }
}