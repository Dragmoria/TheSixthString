<?php

namespace Service;

use Lib\Database\Entity\Category;
use Lib\Database\Entity\Product;
use Models\CategoryModel;
use Models\ProductModel;
use Models\SimpleCategoryModel;

class CategoryService extends BaseDatabaseService
{
    public function getById(int $id): SimpleCategoryModel
    {
        $query = "select * from category where id = ?";

        $categoryEntity = $this->executeQuery($query, [$id], Category::class)[0];

        $model = SimpleCategoryModel::convertToModel($categoryEntity);

        return $model;
    }

    public function getActiveCategories(?int $selectedCategoryId): array
    {
        $query = "select id, name, media from category where active = 1 ";
        $params = array();

        if (is_null($selectedCategoryId)) {
            $query .= "and parentId is null";
        } else {
            $query .= "and (parentId = ? or id = ?)";
            array_push($params, $selectedCategoryId, $selectedCategoryId);
        }

        $query .= " order by name";

        $models = array();

        $categoryEntities = $this->executeQuery($query, $params, Category::class);
        foreach ($categoryEntities as $entity) {
            $model = CategoryModel::convertToModel($entity);

            if ($entity->id == $selectedCategoryId) {
                $model->isSelectedCategory = true;
                $this->fillSelectedCategoryModel($selectedCategoryId, $model);
            }

            $models[] = $model;
        }

        return $models;
    }

    public function getActiveCategoriesWithChildren(?array $columns = null): array
    {
        $columnsToSelect = "*";
        if (!empty($columns)) {
            $columnsToSelect = implode(",", $columns);
        }

        $queryResult = $this->executeQuery("select $columnsToSelect from category where active = ? order by parentId", [1], Category::class); //sort by parentId so the categories without a parent come first

        $models = array();
        foreach ($queryResult as $resultItem) {
            $this->addToResult($resultItem, $models);
        }

        return $models;
    }

    private function addToResult(Category $entity, array &$models): void
    {
        if ($entity->parentId == null) {
            $models[] = CategoryModel::convertToModel($entity);
            return;
        }

        foreach ($models as $model) {
            if ($entity->parentId == $model->id) {
                $model->children[] = CategoryModel::convertToModel($entity);
                return;
            }

            $this->addToResult($entity, $model->children);
        }
    }

    private function fillSelectedCategoryModel(int $id, CategoryModel &$model): void
    {
        $productEntities = $this->executeQuery("select * from product where categoryId = ?", [$id], Product::class);
        foreach ($productEntities as $entity) {
            $model->products[] = ProductModel::convertToModel($entity);
        }
    }

    public function getAllCategories(): ?array
    {
        $query = "select * from category order by parentId";

        $results = $this->executeQuery($query, [], Category::class);


        $models = [];
        foreach ($results as $category) {
            if ($category->parentId == null) {
                $models[] = SimpleCategoryModel::convertToModel($category);
                continue;
            }

            $parent = null;
            foreach ($models as $model) {
                if ($model->id == $category->parentId) {
                    $parent = $model;
                    break;
                }
            }

            $models[] = SimpleCategoryModel::convertToModel($category, $parent);
        }

        if (count($models) === 0) return null;

        return $models;
    }

    public function addCategory(SimpleCategoryModel $category): bool
    {
        $query = "INSERT INTO category (name, description, active, media, parentId) values (?, ?, ?, ?, ?)";

        $params = [
            $category->name,
            $category->description,
            $category->active,
            json_encode($category->media, JSON_PRETTY_PRINT),
            $category->parentCategory === null ? null : $category->parentCategory->id
        ];

        $result = $this->executeQuery($query, $params);

        return $result;
    }

    public function updateCategory(SimpleCategoryModel $category): bool
    {
        $query = "UPDATE category SET name = ?, description = ?, active = ?, media = ?, parentId = ? WHERE id = ?";

        $params = [
            $category->name,
            $category->description,
            $category->active,
            json_encode($category->media, JSON_PRETTY_PRINT),
            $category->parentCategory ?? null,
            $category->id
        ];

        $result = $this->executeQuery($query, $params);

        return $result;
    }
}
