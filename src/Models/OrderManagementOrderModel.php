<?php

namespace Models;

use Lib\Enums\MolliePaymentStatus;
use Lib\Enums\ShippingStatus;

class OrderManagementOrderModel
{
    public int $id;

    public int $orderItemsCount;

    public float $orderTotal;

    public float $orderTax;

    public AddressModel $shippingAddress;

    public MolliePaymentStatus $paymentStatus;

    public ShippingStatus $shippingStatus;

    public \DateTime $createdOn;

    public array $orderItems;
}