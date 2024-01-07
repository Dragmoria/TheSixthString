<?php

namespace Models;



use Lib\Database\Entity\ReturnItem;
use Lib\Enums\OrderItemStatus;


class ReturnItemModel
{
    function __construct()
    {
    }
    public int $id;
    public int $returnOrderId;
    public int $productId;
    public float $unitPrice;
    public int $quantity;
    public OrderItemStatus $status;



    public static function convertToModel(?ReturnItem $entity): ?ReturnItemModel
    {
        if ($entity->isEmptyObject()) return null;

        $model = new ReturnItemModel();

        $model->id = $entity->id;
        $model->returnOrderId = $entity->returnOrderId;
        $model->productId = $entity->productId;
        $model->unitPrice = $entity->unitPrice;
        $model->quantity = $entity->quantity;
        $model->status = OrderItemStatus::from($entity->status);
  
        return $model;
    }
    
    public function convertToEntity(): ReturnItem
    {
        $entity = new ReturnItem();

        $entity->id = $this->id;
        $entity->returnOrderId = $this->returnOrderId;
        $entity->productId = $this->productId;
        $entity->unitPrice = $this->unitPrice;
        $entity->quantity = $this->quantity;
        $entity->status = $this->status->value;


        return $entity;
    }
}
