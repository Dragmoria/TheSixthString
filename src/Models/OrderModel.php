<?php

namespace Models;

use Lib\Database\Entity\Order;
use Lib\Enums\PaymentStatus;
use Lib\Enums\ShippingStatus;

class OrderModel
{
    function __construct()
    {
    }
    public int $id;
    public int $userId;
    public float $orderTotal;
    public float $orderTax;
    public ?int $couponId;
    public int $shippingAddressId;
    public int $invoiceAddressId;
    public PaymentStatus $paymentStatus;
    public ShippingStatus $shippingStatus;
    public \DateTime $createdOn;




    public static function convertToModel(?Order $entity): ?OrderModel
    {
        if ($entity->isEmptyObject()) return null;

        $model = new OrderModel();

        $model->id = $entity->id;
        $model->userId = $entity->userId;
        $model->orderTotal = $entity->orderTotal;
        $model->orderTax = $entity->orderTax;
        $model->couponId = $entity->couponId;
        $model->shippingAddressId = $entity->shippingAddressId;
        $model->invoiceAddressId = $entity->invoiceAddressId;
        $model->paymentStatus = PaymentStatus::from($entity->paymentStatus);
        $model->shippingStatus = ShippingStatus::from($entity->shippingStatus);
        $model->createdOn = new \DateTime($entity->createdOn);
  
        return $model;
    }
    
    public function convertToEntity(): Order
    {
        $entity = new Order();

        $entity->id = $this->id;
        $entity->userId = $this->userId;
        $entity->orderTotal = $this->orderTotal;
        $entity->orderTax = $this->orderTax;
        $entity->couponId = $this->couponId;
        $entity->shippingAddressId = $this->shippingAddressId;
        $entity->invoiceAddressId = $this->invoiceAddressId;
        $entity->paymentStatus = $this->paymentStatus->value;
        $entity->shippingStatus = $this->shippingStatus->value;
        $entity->createdOn = $this->createdOn->format('j F Y');

        return $entity;
    }
}
