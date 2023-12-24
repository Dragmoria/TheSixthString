<?php

namespace Service;

use Lib\Database\Entity\User;
use Lib\Enums\Role;
use Models\UserModel;


class ActivateService extends BaseDatabaseService
{
    

public function getUserByLink(string $link): ?UserModel
{
    $user = $this->getByLink($link);

    if ($user === null) return null;
    $model = UserModel::convertToModel($user);

    return $model;
}


public function newActivationLink(UserModel $newActivationLink): bool
{
    $query = "UPDATE user SET `activationLink` = ? WHERE id = ?;";

    $user = $newActivationLink;

    $params = [
        $user->activationLink,
        $user->id
    ];

    $result = $this->executeQuery($query, $params);

    return $result !== false;
}
public function changeActiveStatus(UserModel $changeStatus): bool
{
    $query = "UPDATE user SET `active` = ? WHERE activationLink = ? AND id = ?;";

    $user = $changeStatus;

    $params = [
        $user->active,
        $user->activationLink,
        $user->id
    ];

    $result = $this->executeQuery($query, $params);
    
    return $result !== false;
}






private function getByLink(string $link): ?User
{
    $query = 'SELECT * FROM user WHERE activationLink = ? LIMIT 1';
    $params = [$link];

    $result = $this->executeQuery($query, $params, User::class);

    if (count($result) === 0) return null;
    // Assuming the query returns only one user
    return $result[0];
}

}