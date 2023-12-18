<?php

namespace Models;

use Lib\Database\Entity\Product;
use Lib\Helpers\TaxHelper;

class ProductModel {
    public function __construct() { }

    public int $id = 0;
    public string $name = "";
    public string $subtitle = "";
    public string $description = "";
    public bool $active = false;
    public int $amountInStock = 0;
    public int $demoAmountInStock = 0;
    public float $unitPrice = 0;
    public float $recommendedUnitPrice = 0;
    public string $sku = "";
    public ?BrandModel $brand = null;
    public ?CategoryModel $category = null;
    public ?MediaModel $media = null;
    public string $createdOn = "";
    public array $reviews = array();
    public ?float $reviewAverage = null;

    public static function convertToModel(?Product $entity): ?ProductModel {
        if($entity->isEmptyObject()) return null;

        $model = new ProductModel();
        $model->id = $entity->id;
        $model->name = $entity->name;
        $model->subtitle = $entity->subtitle;
        $model->description = $entity->description;
        $model->active = $entity->active;
        $model->amountInStock = $entity->amountInStock;
        $model->demoAmountInStock = $entity->demoAmountInStock;
        $model->unitPrice = TaxHelper::calculatePriceIncludingTax($entity->unitPrice);
        $model->recommendedUnitPrice = TaxHelper::calculatePriceIncludingTax($entity->recommendedUnitPrice);
        $model->sku = $entity->sku;
        $model->media = MediaModel::convertToModel($entity->media);
        $model->createdOn = $entity->createdOn;

        return $model;
    }
}