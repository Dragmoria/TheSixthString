<?php

namespace Lib\Database\Entity;

use Lib\Database\Entity\SaveableObject;

class Product extends SaveableObject {
    public function __construct() {
        $this->tableName = "product";
    }

    public string $name = "";
    public string $subtitle = "";
    public string $description = "";
    public bool $active = false;
    public int $amountInStock = 0;
    public int $demoAmountInStock = 0;
    public float $unitPrice = 0;
    public float $recommendedUnitPrice = 0;
    public string $sku = "";
    public ?int $brandId = null;
    public ?int $categoryId = null;
    public ?string $media = null;
    public string $createdOn = "";
}