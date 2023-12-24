<?php

namespace Service;

use Lib\Database\Entity\Product;
use Lib\Database\Entity\TryoutSchedule;
use Lib\Enums\Months;
use Lib\MVCCore\Application;
use Models\ProductModel;
use Models\TryoutScheduleModel;

class TryoutScheduleService extends BaseDatabaseService
{
    public function getScheduleForMonth(Months $month): ?array
    {
        $query = 'SELECT * FROM tryoutschedule WHERE MONTH(startDate) = ?';
        $params = [$month->value];

        $result = $this->executeQuery($query, $params, TryoutSchedule::class);

        $productCache = [];
        $productService = Application::resolve(ProductService::class);

        $models = [];
        foreach ($result as $entity) {
            $model = TryoutScheduleModel::convertToModel($entity);

            if (!array_key_exists($entity->productId, $productCache)) {
                $productCache[$entity->productId] = $productService->getProductDetails($entity->productId);
            }

            $model->product = $productCache[$entity->productId];


            array_push($models, $model);
        }

        if (count($models) === 0) return null;

        return $models;
    }
}
