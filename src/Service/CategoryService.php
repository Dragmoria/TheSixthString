<?php

namespace Service;

use Lib\Database\Entity\Category;
use Models\CategoryModel;

class CategoryService extends BaseDatabaseService {
    public function getCategories(): array {
        $queryResult = $this->query("select * from category order by parentId")->fetch_all(MYSQLI_ASSOC); //sort by parentId so the categories without a parent come first
        $models = array();
        foreach($queryResult as $resultItem) {
            $this->addToResult($resultItem, $models);
        }

        return $models;
    }

    private function addToResult(array $resultItem, array &$result): void {
        $entity = cast(Category::class, $resultItem);

        if($entity->parentId == null) {
            array_push($result, CategoryModel::convertToModel($entity));
            return;
        }

        foreach($result as $resultItem) {
            if($entity->parentId == $resultItem->id) {
                array_push($resultItem->children, CategoryModel::convertToModel($entity));
                return;
            }

            $this->addToResult($entity, $resultItem->children);
        }
    }
}