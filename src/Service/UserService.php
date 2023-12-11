<?php

namespace Service;

use Lib\Database\Entity\User;
use Lib\Enums\Role;
use Models\UserModel;

class UserService extends BaseDatabaseService
{
    public function getEmployees(): array
    {
        $query = 'SELECT * FROM user WHERE role = ? OR role = ? OR role = ?';
        $params = [Role::Analyst->value, Role::Manager->value, Role::Admin->value];

        $result = $this->executeQuery($query, $params, User::class);

        $models = [];
        foreach ($result as $entity) {
            array_push($models, UserModel::convertToModel($entity));
        }

        return $models;
    }

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
            $input->createdOn->format('Y-m-d H:i:s')
        ];

        $result = $this->executeQuery($query, $params);

        return $result !== false;
    }

    public function updateUser(UserModel $updateUser): bool
    {
        $query = "UPDATE user SET `role` = ?, `firstName` = ?, `insertion` = ?, `lastName` = ?, `dateOfBirth` = ?, `gender` = ? WHERE id = ?;";

        $user = $updateUser->convertToEntity();

        $params = [
            $user->role,
            $user->firstName,
            $user->insertion,
            $user->lastName,
            $user->dateOfBirth,
            $user->gender,
            $user->id
        ];

        $result = $this->executeQuery($query, $params);

        return $result !== false;
    }

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
