<?php

namespace Service;

use Lib\Database\Entity\User;
use Lib\Enums\Role;
use Models\UserModel;

class UserService extends BaseDatabaseService
{
    public function getUserById(int $id): UserModel
    {
        $user = $this->getById($id);

        $model = UserModel::convertToModel($user);

        return $model;
    }

    public function getUserByEmail(string $email): UserModel
    {
        $user = $this->getByEmail($email);

        $model = UserModel::convertToModel($user);

        return $model;
    }

    public function getUsersByRole(Role $role): array
    {
        $query = 'SELECT * FROM user WHERE role = ?';
        $params = [$role->value];

        $result = $this->executeQuery($query, $params, User::class);

        $models = [];
        foreach ($result as $entity) {
            array_push($models, UserModel::convertToModel($entity));
        }

        return $models;
    }

    public function createUser(UserModel $input): bool
    {
        $query = "INSERT INTO user (`emailAddress`, `passwordHash`, `role`, `firstName`, `insertion`, `lastName`, `dateOfBirth`, `gender`, `active`, `createdOn`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

        $params = [
            $input->emailAddress,
            $input->passwordHash,
            $input->role->value,
            $input->firstName,
            $input->insertion,
            $input->lastName,
            $input->dateOfBirth->format('Y-m-d'),
            $input->gender->value,
            $input->active,
            $input->createdOn->format('Y-m-d')
        ];

        $result = $this->executeQuery($query, $params);

        return $result !== false;
    }

    // public function editUser(UserModel $input): bool
    // {
    // }

    private function getById(int $id): User
    {
        $query = 'SELECT * FROM user WHERE id = ? LIMIT 1';
        $params = [$id];

        $result = $this->executeQuery($query, $params, User::class);

        return $result[0];
    }

    private function getByEmail(string $email): User
    {
        $query = 'SELECT * FROM user WHERE emailAddress = ? LIMIT 1';
        $params = [$email];

        $result = $this->executeQuery($query, $params, User::class);

        // Assuming the query returns only one user
        return $result[0];
    }
}
