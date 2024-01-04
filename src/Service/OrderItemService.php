<?php

namespace Service;

use Lib\Database\Entity\OrderItem;
use Models\OrderItemModel;

class OrderItemService extends BaseDatabaseService {
    public function getOrderItemByOrderId(int $orderId): ?array {
        $query = "SELECT * FROM `orderitem` WHERE orderId = ?;";
        $params = [$orderId];

        $result = $this->executeQuery($query, $params, OrderItem::class);

        $models = [];
        foreach ($result as $entity) {
            array_push($models, OrderItemModel::convertToModel($entity));
        }

        if (count($models) === 0) return null;
        return $models;
    }
}