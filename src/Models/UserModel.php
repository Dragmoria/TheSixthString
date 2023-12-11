<?php

namespace Models;

use Lib\Database\Entity\User;
use Lib\Enums\Gender;
use Lib\Enums\Role;

class UserModel
{
    function __construct()
    {
    }

    public int $id;
    public string $emailAddress;
    public string $passwordHash;
    public Role $role;
    public string $firstName;
    public ?string $insertion;
    public string $lastName;
    public ?\DateTime $dateOfBirth;
    public Gender $gender;
    public bool $active;
    public \DateTime $createdOn;


    public static function convertToModel(?User $entity): ?UserModel
    {
        if ($entity->isEmptyObject()) return null;

        $model = new UserModel();

        $model->id = $entity->id;
        $model->emailAddress = $entity->emailAddress;
        $model->passwordHash = $entity->passwordHash;
        $model->role = Role::from($entity->role);
        $model->firstName = $entity->firstName;
        $model->insertion = $entity->insertion;
        $model->lastName = $entity->lastName;
        $model->dateOfBirth = new \DateTime($entity->dateOfBirth);
        $model->gender = Gender::from($entity->gender);
        $model->active = $entity->active;
        $model->createdOn = new \DateTime($entity->createdOn);

        return $model;
    }

    public function convertToEntity(): User
    {
        $entity = new User();

        $entity->emailAddress = $this->emailAddress;
        $entity->passwordHash = $this->passwordHash;
        $entity->role = $this->role->value;
        $entity->firstName = $this->firstName;
        $entity->insertion = $this->insertion;
        $entity->lastName = $this->lastName;
        $entity->dateOfBirth = $this->dateOfBirth;
        $entity->gender = $this->gender->value;

        return $entity;
    }
}
