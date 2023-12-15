<?php

namespace Service;

use Lib\Database\Entity\Coupon;
use Lib\Enums\CouponType;
use Lib\Enums\SortOrder;
use Models\CouponModel;

class CouponService extends BaseDatabaseService
{
    public function getCoupons(string $sortField, SortOrder $sortOrder): ?array
    {
        $query = 'SELECT * FROM coupon';

        $params = [];

        $validSortFields = ["id", "name", "code", "value", "startDate", "endDate", "usageAmount", "maxUsageAmount", "active", "type"];

        if (in_array($sortField, $validSortFields)) {
            $query .= ' ORDER BY ' . $sortField . ' ' . $sortOrder->value;
        }

        $result = $this->executeQuery($query, $params, Coupon::class);

        $models = [];
        foreach ($result as $entity) {
            array_push($models, CouponModel::convertToModel($entity));
        }

        if (count($models) === 0) return null;
        return $models;
    }

    public function getCouponById(int $id): ?CouponModel
    {
        $query = 'SELECT * FROM coupon WHERE id = ?';

        $params = [$id];

        $result = $this->executeQuery($query, $params, Coupon::class);

        if (count($result) === 0) return null;
        $model = CouponModel::convertToModel($result[0]);
        return $model;
    }

    public function updateCoupon(CouponModel $couponModel): bool
    {
        $query = 'UPDATE coupon SET name = ?, code = ?, value = ?, endDate = ?, maxUsageAmount = ?, active = ?, type = ? WHERE id = ?';


        $params = [
            $couponModel->name,
            $couponModel->code,
            $couponModel->value,
            $couponModel->endDate === null ? null : $couponModel->endDate->format('Y-m-d'),
            $couponModel->maxUsageAmount,
            $couponModel->active,
            $couponModel->type->value,
            $couponModel->id
        ];

        $result = $this->executeQuery($query, $params);

        return $result !== false;
    }

    public function addCoupon(CouponModel $newCoupon): bool
    {
        $query = 'INSERT INTO coupon (name, code, value, startDate, endDate, usageAmount, maxUsageAmount, active, type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';

        $params = [
            $newCoupon->name,
            $newCoupon->code,
            $newCoupon->value,
            $newCoupon->startDate->format('Y-m-d'),
            $newCoupon->endDate === null ? null : $newCoupon->endDate->format('Y-m-d'),
            0,
            $newCoupon->maxUsageAmount,
            $newCoupon->active,
            $newCoupon->type->value
        ];

        $result = $this->executeQuery($query, $params);

        return $result;
    }
}
