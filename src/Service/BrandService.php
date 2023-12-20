<?php

namespace Service;

use Lib\Database\Entity\Brand;
use Lib\Enums\SortOrder;
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

    public function getBrands(string $sortField, SortOrder $sortOrder): ?array
    {
        $query = 'SELECT * FROM brand';

        $params = [];

        $validSortFields = ["id", "name", "logo", "active"];

        if (in_array($sortField, $validSortFields)) {
            $query .= ' ORDER BY ' . $sortField . ' ' . $sortOrder->value;
        }

        $result = $this->executeQuery($query, $params, Brand::class);

        $models = [];
        foreach ($result as $entity) {
            array_push($models, BrandModel::convertToModel($entity));
        }

        if (count($models) === 0) return null;
        return $models;
    }

    public function addBrand(BrandModel $brand): bool
    {
        $query = 'INSERT INTO brand (name, description, active) VALUES (?, ?, ?)';

        $params = [
            $brand->name,
            $brand->description,
            $brand->active
        ];

        $result = $this->executeQuery($query, $params);

        return $result;
    }

    public function updateBrand(BrandModel $brand): bool
    {
        $query = 'UPDATE brand SET name = ?, description = ?, active = ? WHERE id = ?';

        $params = [
            $brand->name,
            $brand->description,
            $brand->active,
            $brand->id
        ];

        $result = $this->executeQuery($query, $params);

        return $result;
    }

    public function getBrandById(int $id): ?BrandModel
    {
        $query = 'SELECT * FROM brand WHERE id = ?';

        $params = [$id];

        $result = $this->executeQuery($query, $params, Brand::class);

        if (count($result) === 0) return null;
        $model = BrandModel::convertToModel($result[0]);
        return $model;
    }
}
