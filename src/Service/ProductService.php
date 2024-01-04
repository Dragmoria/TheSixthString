<?php

namespace Service;

use Lib\Database\Entity\Brand;
use Lib\Database\Entity\Category;
use Lib\Database\Entity\Product;
use Lib\Database\Entity\Review;
use Lib\Enums\ReviewStatus;
use Lib\Enums\SortType;
use Lib\Helpers\TaxHelper;
use Models\AdminProductFilterModel;
use Models\BrandModel;
use Models\CategoryModel;
use Models\CustomerProductFilterModel;
use Models\ProductFilterModel;
use Models\ProductModel;
use Models\ReviewModel;

class ProductService extends BaseDatabaseService
{
    public function getProducts(CustomerProductFilterModel $model): array
    {
        $query = "select id, name, recommendedUnitPrice, unitPrice, media from product where active = ?";
        $params = [1];

        $this->buildFilteredQuery($query, $params, $model);
        $entities = $this->executeQuery($query, $params, Product::class);

        $models = array();
        foreach ($entities as $entity) {
            $models[] = ProductModel::convertToModel($entity);
        }

        return $models;
    }

    public function getProductDetails(int $id): ProductModel
    {
        $productEntity = $this->executeQuery("select * from product where id = ?", [$id], Product::class)[0];
        $model = ProductModel::convertToModel($productEntity);

        if (!is_null($productEntity->brandId)) {
            $brandEntity = $this->executeQuery("select * from brand where id = ?", [$productEntity->brandId], Brand::class)[0];
            $model->brand = BrandModel::convertToModel($brandEntity);
        }

        if (!is_null($productEntity->categoryId)) {
            $categoryEntity = $this->executeQuery("select * from category where id = ?", [$productEntity->categoryId], Category::class)[0];
            $model->category = CategoryModel::convertToModel($categoryEntity);
        }

        $reviewEntities = $this->executeQuery("select rev.* from review rev inner join orderitem item on item.id = rev.orderItemId where rev.status = ? and item.productId = ?", [ReviewStatus::Accepted->value, $productEntity->id], Review::class);
        foreach ($reviewEntities as $reviewEntity) {
            $model->reviews[] = ReviewModel::convertToModel($reviewEntity);
        }

        $reviewAverage = $this->executeQuery("select sum(rev.rating) / count(rev.id) as reviewAverage from review rev inner join orderitem item on item.id = rev.orderItemId where rev.status = ? and item.productId = ?", [ReviewStatus::Accepted->value, $productEntity->id])[0]->reviewAverage;
        $model->reviewAverage = round((float)$reviewAverage, 1);
        return $model;
    }

    public function getAmountInStockForProduct(int $productId): int
    {
        return $this->executeQuery("select amountInStock from product where id = ?", [$productId])[0]->amountInStock;
    }

    private function buildFilteredQuery(string &$query, array &$params, CustomerProductFilterModel $model): void
    {
        if (!is_null($model->categoryId)) {
            $categoryIds = $this->getAllChildCategoriesForParent($model->categoryId);
            $categoryIds[] = $model->categoryId;

            $query .= " and categoryId in (" . substr(str_repeat(",?", count($categoryIds)), 1) . ")";
            $params = array_merge($params, $categoryIds);
        }

        if (!is_null($model->brandId)) {
            $query .= " and brandId = ?";
            $params[] = $model->brandId;
        }

        $query .= " and amountInStock " . ($model->isInStock ? "> ?" : "= ?");
        $params[] = 0;

        $query .= " and unitPrice >= ? and unitPrice <= ?";
        $params[] = TaxHelper::calculatePriceExcludingTax($model->minPrice);
        $params[] = TaxHelper::calculatePriceExcludingTax($model->maxPrice);

        $query .= " order by " . $this->getSortOrder($model->sortOrder);
    }

    private function getSortOrder(SortType $sortType): string
    {
        switch ($sortType) {
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

    private function getAllChildCategoriesForParent(int $parentId): array
    {
        $query = "with recursive cte as ( select cat.id, cat.name, cat.parentId from category cat union all select c.id,c.name, cat.parentId from category cat inner join cte c on c.parentId = cat.Id) select c.id from cte c where parentId = $parentId";
        $queryResult = $this->query($query)->fetch_all(MYSQLI_ASSOC);

        $childIds = array();
        foreach ($queryResult as $item) {
            $childIds[] = (int)$item["id"];
        }

        return $childIds;
    }

    public function getAllProducts(AdminProductFilterModel $filters): ?array
    {
        $query = "select * from product where 1=1";
        $params = [];

        if (!is_null($filters->categoryId)) {
            $query .= " AND categoryId = ?";
            $params[] = $filters->categoryId;
        }

        if (!is_null($filters->brandId)) {
            $query .= " AND brandId = ?";
            $params[] = $filters->brandId;
        }

        if (!is_null($filters->sku)) {
            $query .= " AND sku LIKE ?";
            $params[] = '%' . $filters->sku . '%';
        }

        if (!is_null($filters->active)) {
            $query .= " AND active = ?";
            $params[] = $filters->active;
        }

        if (!is_null($filters->name)) {
            $query .= " AND name LIKE ?";
            $params[] = '%' . $filters->name . '%';
        }

        $query .= " order by name";

        $entities = $this->executeQuery($query, $params, Product::class);


        $brands = [];
        $categories = [];


        $models = [];
        foreach ($entities as $entity) {
            $model = ProductModel::convertToModel($entity);

            if (!is_null($entity->brandId)) {
                if (!array_key_exists($entity->brandId, $brands)) {
                    $brandEntity = $this->executeQuery("select * from brand where id = ?", [$entity->brandId], Brand::class)[0];
                    $brands[$entity->brandId] = BrandModel::convertToModel($brandEntity);
                }

                $model->brand = $brands[$entity->brandId];
            }

            if (!is_null($entity->categoryId)) {
                if (!array_key_exists($entity->categoryId, $categories)) {
                    $categoryEntity = $this->executeQuery("select * from category where id = ?", [$entity->categoryId], Category::class)[0];
                    $categories[$entity->categoryId] = CategoryModel::convertToModel($categoryEntity);
                }

                $model->category = $categories[$entity->categoryId];
            }

            $models[] = $model;
        }

        return $models;
    }

    public function addProduct(ProductModel $model): bool
    {
        $query = "INSERT INTO product
        (name, subtitle, description, active, amountInStock, demoAmountInStock, unitPrice, recommendedUnitPrice, sku, brandId, categoryId, media, createdOn)
        VALUES
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $params = [
            $model->name,
            $model->subtitle,
            $model->description,
            $model->active,
            $model->amountInStock,
            $model->demoAmountInStock,
            TaxHelper::calculatePriceExcludingTax($model->unitPrice),
            TaxHelper::calculatePriceExcludingTax($model->recommendedUnitPrice),
            $model->sku,
            $model->brand->id,
            $model->category->id,
            json_encode($model->media, JSON_PRETTY_PRINT),
            date("Y-m-d H:i:s")
        ];

        $result = $this->executeQuery($query, $params);

        return $result;
    }
}
