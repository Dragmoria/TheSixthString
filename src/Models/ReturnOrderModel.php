<?php

namespace Models;

use Lib\Database\Entity\ReturnOrder;
use lib\Enums\ShippingStatus;

class ReturnOrderModel
{
    function __construct()
    {
    }
    public int $id;
    public int $orderId;
    public float $returnTotal;
    public ShippingStatus $shippingStatus;
    public \DateTime $createdOn;




    public static function convertToModel(?ReturnOrder $entity): ?ReturnOrderModel
    {
        if ($entity->isEmptyObject()) return null;

        $model = new ReturnOrderModel();

        $model->id = $entity->id;
        $model->orderId = $entity->orderId;
        $model->returnTotal = $entity->returnTotal;
        $model->shippingStatus = ShippingStatus::from($entity->shippingStatus);
        $model->createdOn = new \DateTime($entity->createdOn);
  
        return $model;
    }
    
    public function convertToEntity(): ReturnOrder
    {
        $entity = new ReturnOrder();

        $entity->id = $this->id;
        $entity->orderId = $this->orderId;
        $entity->returnTotal = $this->returnTotal;
        $entity->shippingStatus = $this->shippingStatus->value;
        $entity->createdOn = $this->createdOn->format('j F Y');

        return $entity;
    }
}
