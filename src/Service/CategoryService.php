<?php

namespace Service;

use Lib\Database\Entity\Category;
use Lib\Database\Entity\Product;
use Models\CategoryModel;
use Models\ProductModel;

class CategoryService extends BaseDatabaseService {
    public function getCategories(?int $selectedCategoryId): array {
        $query = "select id, name, media from category where active = 1 ";
        $params = array();

        if(is_null($selectedCategoryId)) {
            $query .= "and parentId is null";
        } else {
            $query .= "and (parentId = ? or id = ?)";
            array_push($params, $selectedCategoryId, $selectedCategoryId);
        }

        $query .= " order by name";

        $models = array();

        $categoryEntities = $this->executeQuery($query, $params, Category::class);
        foreach($categoryEntities as $entity) {
            $model = CategoryModel::convertToModel($entity);

            if($entity->id == $selectedCategoryId) {
                $model->isSelectedCategory = true;
                $this->fillSelectedCategoryModel($selectedCategoryId, $model);
            }

            $models[] = $model;
        }

        return $models;
    }

    private function fillSelectedCategoryModel(int $id, CategoryModel &$model): void {
        $productEntities = $this->executeQuery("select * from product where categoryId = ?", [$id], Product::class);
        foreach($productEntities as $entity) {
            $model->products[] = ProductModel::convertToModel($entity);
        }
    }
}