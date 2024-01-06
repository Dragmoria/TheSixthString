<?php

namespace Models;

use Lib\Database\Entity\Resetpassword;

class ResetpasswordModel
{
    function __construct()
    {
    }

    public int $id;
    public int $userId;
    public ?UserModel $user;
    public string $link;
    public \DateTime $validUntil;

    public static function convertToModel(?Resetpassword $entity): ?ResetpasswordModel
    {
        if ($entity->isEmptyObject())
            return null;

        $model = new ResetpasswordModel();

        $model->id = $entity->id;
        $model->userId = $entity->userId;
        $model->link = $entity->link;
        $model->validUntil = new \DateTime($entity->validUntil);


        return $model;
    }

    public function convertToEntity(): Resetpassword
    {
        $entity = new Resetpassword();

        $entity->id = $this->id;
        $entity->userId = $this->userId;
        $entity->link = $this->link;
        $entity->validUntil = $this->validUntil->format('Y-m-d');


        return $entity;
    }
}



