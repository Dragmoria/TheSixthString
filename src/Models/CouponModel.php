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
    public string $code;
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

        $model = new CouponModel();

        $model->id = $entity->id;
        $model->name = $entity->name;
        $model->code = $entity->code;
        $model->value = $entity->value;
        $model->startDate = new \DateTime($entity->startDate);
        $model->endDate = $entity->endDate === null ? null : new \DateTime($entity->endDate);
        $model->usageAmount = $entity->usageAmount;
        $model->maxUsageAmount = $entity->maxUsageAmount;
        $model->active = $entity->active;
        $model->type = CouponType::from($entity->type);

        return $model;
    }

    public function convertToEntity(): Coupon
    {
        $entity = new Coupon();

        $entity->id = $this->id;
        $entity->name = $this->name;
        $entity->code = $this->code;
        $entity->value = $this->value;
        $entity->startDate = $this->startDate->format('Y-m-d');
        $entity->endDate = $this->endDate === null ? null : $this->endDate->format('Y-m-d');
        $entity->usageAmount = $this->usageAmount;
        $entity->maxUsageAmount = $this->maxUsageAmount;
        $entity->active = $this->active;
        $entity->type = $this->type->value;

        return $entity;
    }
}
