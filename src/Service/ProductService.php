<?php

namespace Service;

use http\Exception\InvalidArgumentException;
use Lib\Database\Entity\Brand;
use Lib\Database\Entity\Category;
use Lib\Database\Entity\Product;
use Lib\Database\Entity\Review;
use Lib\Enums\ReviewStatus;
use Lib\Enums\SortType;
use Models\BrandModel;
use Models\CategoryModel;
use Models\ProductFilterModel;
use Models\ProductModel;
use Models\ReviewModel;

class ProductService extends BaseDatabaseService {
    public function getProducts(ProductFilterModel $model): array {
        $query = "select id, name, recommendedUnitPrice, unitPrice, media from product where active = ?";
        $params = [1];

        $this->buildFilteredQuery($query, $params, $model);
        $entities = $this->executeQuery($query, $params, Product::class);

        $models = array();
        foreach($entities as $entity) {
            $models[] = ProductModel::convertToModel($entity);
        }

        return $models;
    }

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

    private function buildFilteredQuery(string &$query, array &$params, ProductFilterModel $model): void {
        if(!is_null($model->categoryId)) {
            $query .= " and categoryId = ?";
            $params[] = $model->categoryId;
        }

        if(!is_null($model->brandId)) {
            $query .= " and brandId = ?";
            $params[] = $model->brandId;
        }

        $query .= " and amountInStock " . ($model->isInStock ? "> ?" : "= ?");
        $params[] = 0;

        $query .= " and unitPrice >= ? and unitPrice <= ?";
        $params[] = $model->minPrice;
        $params[] = $model->maxPrice;

        $query .= " order by " . $this->getSortOrder($model->sortOrder);
    }

    private function getSortOrder(SortType $sortType): string {
        switch($sortType) {
            case SortType::PriceAsc:
                return "unitPrice asc";
            case SortType::PriceDesc:
                return "unitPrice desc";
            case SortType::NameAsc:
                return "name asc";
            case SortType::NameDesc:
                return "name desc";
            default:
                throw new \InvalidArgumentException("Invalid sort type $sortType->name");
        }
    }
}