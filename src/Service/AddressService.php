<?php

namespace Service;

use Lib\Database\Entity\Address;
use Models\AddressModel;

class AddressService extends BaseDatabaseService
{
    public function getAddressByUserId(int $userId, int $type): ?AddressModel
    {
        $address = $this->getByUserIdAndType($userId,$type);

        if ($address === null)
            return null;
        $model = AddressModel::convertToModel($address);

        return $model;
    }

    public function createAddress(AddressModel $input): ?AddressModel
    {
        $query = "INSERT INTO address (`userId`, `street`, `housenumber`, `housenumberExtension`, `zipCode`, `city`, `country`, `active`, `type`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";

        $params = [
            $input->userId,
            $input->street,
            $input->housenumber,
            $input->housenumberExtension,
            $input->zipCode,
            $input->city,
            $input->country,
            $input->active,
            $input->type,
        ];

        $result = $this->executeQuery($query, $params);
        // return the just created user after getting it from the database
        $Address = $this->getCreatedAddress($input->userId, $input->type);
        return AddressModel::convertToModel($Address);
        
    }



    public function updateAddress(AddressModel $updateAddress): bool
    {
        $query = "UPDATE address SET `street` = ?, `housenumber` = ?, `housenumberExtension` = ?, `zipCode` = ?, `city` = ?, `country` = ? WHERE userId = ? AND type = ?;";

        $Address = $updateAddress->convertToEntity();

        $params = [
            $Address->street,
            $Address->housenumber,
            $Address->housenumberExtension,
            $Address->zipCode,
            $Address->city,
            $Address->country,
            $Address->userId,
            $Address->type
        ];

        $result = $this->executeQuery($query, $params);

        return $result !== false;
    }

    private function getByUserIdAndType(int $userId, int $type): ?Address
    {
        $query = 'SELECT * FROM address WHERE userId = ? AND type = ? LIMIT 1';
        $params = [$userId, $type];

        $result = $this->executeQuery($query, $params, Address::class);

        if (count($result) === 0)
            return null;
        // Assuming the query returns only one user
        return $result[0];
    }

    private function getCreatedAddress(int $userId, int $type): ?Address
    {
        $query = 'SELECT * FROM address WHERE userId = ? AND type = ? LIMIT 1';
        $params = [$userId, $type];

        $result = $this->executeQuery($query, $params, Address::class);
        if (count($result) === 0)
            return null;
        // Assuming the query returns only one user
        return $result[0];
    }



}
