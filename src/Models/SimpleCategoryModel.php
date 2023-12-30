<?php

namespace Models;

use Lib\Database\Entity\Category;

class SimpleCategoryModel
{
    public function __construct()
    {
    }

    public int $id = 0;
    public string $name = "";
    public string $description = "";
    public bool $active = false;
    public ?MediaModel $media = null;
    public ?SimpleCategoryModel $parentCategory = null;

    public static function convertToModel(?Category $entity, SimpleCategoryModel $parent = null): ?SimpleCategoryModel
    {
        if ($entity->isEmptyObject()) return null;

        $model = new SimpleCategoryModel();
        $model->id = $entity->id;
        $model->name = $entity->name;
        $model->description = $entity->description;
        $model->active = $entity->active;
        $model->media = MediaModel::convertToModel($entity->media);
        $model->parentCategory = $parent;

        return $model;
    }
}
