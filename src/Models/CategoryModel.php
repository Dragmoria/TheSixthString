<?php

namespace Models;

use Lib\Database\Entity\Category;

class CategoryModel {
    public function __construct() { }

    public int $id = 0;
    public string $name = "";
    public string $description = "";
    public bool $active = false;
    public ?string $media = null;
    public array $children = array();

    public static function convertToModel(?Category $entity): ?CategoryModel {
        if($entity->isEmptyObject()) return null;

        $model = new CategoryModel();
        $model->id = $entity->id;
        $model->name = $entity->name;
        $model->description = $entity->description;
        $model->active = $entity->active;
        $model->media = $entity->media;

        return $model;
    }
}