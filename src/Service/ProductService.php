<?php

namespace Service;

use Lib\Database\Entity\Brand;
use Lib\Database\Entity\Category;
use Lib\Database\Entity\Product;
use Models\BrandModel;
use Models\CategoryModel;
use Models\ProductModel;

class ProductService extends BaseDatabaseService {
    public function getProductDetails(int $id): ProductModel {
        $productEntity = $this->executeQuery("select * from product where id = ?", [$id], Product::class)[0];
        $model = ProductModel::convertToModel($productEntity);

        if(!is_null($productEntity->brandId)) {
            $brandEntity = $this->executeQuery("select * from brand where id = ?", [$productEntity->brandId], Brand::class)[0];
            $model->brand = BrandModel::convertToModel($brandEntity);
        }

        if(!is_null($productEntity->categoryId)) {}
        $categoryEntity = $this->executeQuery("select * from category where id = ?", [$productEntity->categoryId], Category::class)[0];
        $model->category = CategoryModel::convertToModel($categoryEntity);

        return $model;
    }
}