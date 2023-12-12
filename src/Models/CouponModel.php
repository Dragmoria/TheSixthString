<?php

namespace Models;

use Lib\Database\Entity\Coupon;
use Lib\Enums\CouponType;

class CouponModel
{
    function __construct()
    {
    }

    public int $id;
    public string $name;
    public float $value;
    public \DateTime $startDate;
    public ?\DateTime $endDate;
    public int $usageAmount;
    public ?int $maxUsageAmount;
    public bool $active;
    public CouponType $type;

    public static function convertToModel(?Coupon $entity): ?CouponModel
    {
        if ($entity->isEmptyObject()) return null;

        $model = new UserModel();

        $model->id = $entity->id;


        return $model;
    }

    public function convertToEntity(): Coupon
    {
        $entity = new Coupon();

        $entity->id = $this->id;

        return $entity;
    }
}
