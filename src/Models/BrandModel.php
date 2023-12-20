<?php

namespace Models;

use Lib\Database\Entity\Brand;

class BrandModel
{
    public function __construct()
    {
    }

    public int $id = 0;
    public string $name = "";
    public string $description = "";
    public bool $active = false;

    public static function convertToModel(?Brand $entity): ?BrandModel
    {
        if ($entity->isEmptyObject()) return null;

        $model = new BrandModel();

        $model->id = $entity->id;
        $model->name = $entity->name;
        $model->description = $entity->description;
        $model->active = $entity->active;

        return $model;
    }
}
