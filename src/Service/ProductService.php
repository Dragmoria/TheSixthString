<?php

namespace Service;

use Lib\Database\Entity\Brand;
use Lib\Database\Entity\Category;
use Lib\Database\Entity\Product;
use Lib\Database\Entity\Review;
use Lib\Enums\ReviewStatus;
use Models\BrandModel;
use Models\CategoryModel;
use Models\ProductModel;
use Models\ReviewModel;

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

        $reviewEntities = $this->executeQuery("select rev.* from review rev inner join orderitem item on item.id = rev.orderItemId where rev.status = ? and item.productId = ?", [ReviewStatus::Accepted->value, $productEntity->id], Review::class);
        foreach($reviewEntities as $reviewEntity) {
            $model->reviews[] = ReviewModel::convertToModel($reviewEntity);
        }

        $reviewAverage = $this->executeQuery("select sum(rev.rating) / count(rev.id) as reviewAverage from review rev inner join orderitem item on item.id = rev.orderItemId where rev.status = ? and item.productId = ?", [ReviewStatus::Accepted->value, $productEntity->id])[0]->reviewAverage;
        $model->reviewAverage = round((float)$reviewAverage, 1);
        return $model;
    }
}