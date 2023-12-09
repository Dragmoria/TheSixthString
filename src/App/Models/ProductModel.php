<?php

namespace Models;

use Lib\Database\Entity\Product;

class ProductModel {
    public function __construct() { }

    public string $name = "";
    public string $subtitle = "";
    public string $description = "";
    public bool $active = false;
    public int $amountInStock = 0;
    public int $demoAmountInStock = 0;
    public float $unitPrice = 0;
    public float $recommendedUnitPrice = 0;
    public string $sku = "";
//    public ?BrandModel $brand = null;
//    public ?CategoryModel $category = null;
    public ?string $media = null;
    public string $createdOn = "";

    public static function convertToModel(?Product $entity/*, ?Brand $brand = null, ?Category $category = null*/): ?ProductModel {
        if($entity->isEmptyObject()) return null;

        $model = new ProductModel();

        $model->id = $entity->id;
        $model->name = $entity->name;
        $model->subtitle = $entity->subtitle;
        $model->description = $entity->description;
        $model->active = $entity->active;
        $model->amountInStock = $entity->amountInStock;
        $model->demoAmountInStock = $entity->demoAmountInStock;
        $model->unitPrice = $entity->unitPrice;
        $model->recommendedUnitPrice = $entity->recommendedUnitPrice;
        $model->sku = $entity->sku;
//        $model->brand = BrandModel::convertToModel($entity->brand);
//        $model->category = CategoryModel::convertToModel($entity->category);
        $model->media = $entity->media;
        $model->createdOn = $entity->createdOn;

        return $model;
    }
}