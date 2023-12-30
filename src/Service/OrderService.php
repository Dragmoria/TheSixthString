<?php

namespace Service;

use Lib\Database\Entity\Brand;
use Lib\Database\Entity\Category;
use Lib\Database\Entity\Order;
use Lib\Database\Entity\Product;
use Lib\Database\Entity\Review;
use Lib\Enums\ReviewStatus;
use Lib\Enums\SortType;
use Lib\Helpers\TaxHelper;
use Models\BrandModel;
use Models\CategoryModel;
use Models\OrderModel;
use Models\ProductFilterModel;
use Models\ProductModel;
use Models\ReviewModel;

class OrderService extends BaseDatabaseService {

    public function getOrdersById(int $userId): ?array
    {
        $query = "SELECT * FROM `order` WHERE userId = ? ORDER BY createdOn DESC;";
        $params = [$userId];

        $result = $this->executeQuery($query, $params, Order::class);

        $models = [];
        foreach ($result as $entity) {
            array_push($models, OrderModel::convertToModel($entity));
        }

        if (count($models) === 0) return null;
        return $models;
    }



}