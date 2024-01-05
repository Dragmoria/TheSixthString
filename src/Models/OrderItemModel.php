<?php

namespace Models;


use Lib\Database\Entity\User;
use Lib\Database\Entity\OrderItem;
use Lib\Enums\OrderItemStatus;


class OrderItemModel
{
    function __construct()
    {
    }
    public int $id;
    public int $orderId;
    public int $productId;
    public float $unitPrice; //without tax; multiply before showing to the customer by using Constants::TAX_PERCENTAGE
    public int $quantity;
    public OrderItemStatus $status;



    public static function convertToModel(?OrderItem $entity): ?OrderItemModel
    {
        if ($entity->isEmptyObject()) return null;

        $model = new OrderitemModel();

        $model->id = $entity->id;
        $model->orderId = $entity->orderId;
        $model->productId = $entity->productId;
        $model->unitPrice = $entity->unitPrice;
        $model->quantity = $entity->quantity;
        $model->status = OrderItemStatus::from($entity->status);
  
        return $model;
    }
    
    public function convertToEntity(): OrderItem
    {
        $entity = new OrderItem();

        $entity->id = $this->id;
        $entity->orderId = $this->orderId;
        $entity->productId = $this->productId;
        $entity->unitPrice = $this->unitPrice;
        $entity->quantity = $this->quantity;
        $entity->status = $this->status->value;


        return $entity;
    }
}
