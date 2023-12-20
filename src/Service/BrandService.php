<?php

namespace Service;

use Lib\Database\Entity\Brand;
use Models\BrandModel;

class BrandService extends BaseDatabaseService {
    public function getActiveBrands(): array {
        $entities = $this->executeQuery("select id, name from brand where active = ?", [1], Brand::class);
        $models = array();
        foreach($entities as $entity) {
            $models[] = BrandModel::convertToModel($entity);
        }

        return $models;
    }
}