<?php

namespace Models;

use Lib\Database\Entity\User;

class UserModel {
    function __construct() { }

    public int $id = 0;
    

    public static function convertToModel(?User $entity): ?UserModel {
        if ($entity->isEmptyObject()) return null;

        $model = new UserModel();

        $model->id = $entity->id;
        

        return $model;
    }

    public function convertToEntity(): User {
        $entity = new User();

        return $entity;
    }
}