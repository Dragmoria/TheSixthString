<?php

namespace Service;

use Lib\Database\Entity\Resetpassword;
use Models\ResetpasswordModel;

class ResetpasswordService extends BaseDatabaseService
{
    public function newResetpassword(ResetpasswordModel $resetpasswordModel): bool
    {
        $this->deleteResetpasswordByUserId($resetpasswordModel->userId);

        $query = 'INSERT INTO resetpassword (userId, link, validUntil) VALUES (?, ?, ?)';
        $params = [
            $resetpasswordModel->userId,
            $resetpasswordModel->link, 
            $resetpasswordModel->validUntil->format('Y-m-d H:i:s') 
        ];

        $result = $this->executeQuery($query, $params);

        return $result !== false;
    }

    public function deleteResetpasswordByUserId(int $userId): bool
    {
        $query = 'DELETE FROM resetpassword WHERE userId = ?';
        $params = [$userId];

        $result = $this->executeQuery($query, $params);

        return $result !== false;
    }

    public function getResetpasswordByLink(string $link): ?array
    {
        $query = 'SELECT * FROM resetpassword WHERE link = ?';
        $params = [$link];

        $result = $this->executeQuery($query, $params, Resetpassword::class);

        $models = [];
        foreach ($result as $entity) {
            array_push($models, ResetpasswordModel::convertToModel($entity));
        }

        if (count($models) === 0) return null;

        return $models;
    }


}
