<?php

namespace Service;

use Lib\Database\Entity\ReturnItem;
use Models\ReturnItemModel;

class ReturnItemService extends BaseDatabaseService {
    public function getOrderItemByOrderId(int $orderId): ?array {
        $query = "SELECT * FROM `orderitem` WHERE orderId = ?;";
        $params = [$orderId];

        $result = $this->executeQuery($query, $params, ReturnItem::class);

        $models = [];
        foreach ($result as $entity) {
            array_push($models, ReturnItemModel::convertToModel($entity));
        }

        if (count($models) === 0) return null;
        return $models;
    }
}