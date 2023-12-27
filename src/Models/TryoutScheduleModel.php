<?php

namespace Models;

use Lib\Database\Entity\TryoutSchedule;

class TryoutScheduleModel
{
    public function __construct()
    {
    }

    public int $id = 0;
    public \DateTime $startDate;
    public \DateTime $endDate;
    public ProductModel $product;

    public static function convertToModel(?TryoutSchedule $entity): ?TryoutScheduleModel
    {
        if ($entity->isEmptyObject()) return null;

        $model = new TryoutScheduleModel();
        $model->id = $entity->id;
        $model->startDate = new \DateTime($entity->startDate);
        $model->endDate = new \DateTime($entity->endDate);

        return $model;
    }

    public function convertToEntity(): TryoutSchedule
    {
        $entity = new TryoutSchedule();
        $entity->startDate = $this->startDate->format('Y-m-d H:i:s');
        $entity->endDate = $this->endDate->format('Y-m-d H:i:s');
        $entity->productId = $this->product->id;

        return $entity;
    }
}
