<?php

namespace Service;

class CouponService extends BaseDatabaseService
{
    public function getCoupons(): ?array
    {
        $query = 'SELECT * FROM coupon';

        $result = $this->executeQuery($query, [], \Lib\Database\Entity\Coupon::class);

        $models = [];
        foreach ($result as $entity) {
            array_push($models, Coupon::convertToModel($entity));
        }

        if (count($models) === 0) return null;
        return $models;
    }
}
