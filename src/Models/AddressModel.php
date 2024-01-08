<?php



namespace Models;

use Lib\Database\Entity\Address;
use Lib\Database\Entity\User;
use Lib\Enums\AddressType;
use Lib\Enums\Country;


class AddressModel
{
    function __construct()
    {
    }
    public int $id;
    public int $userId = 0;
    public string $street = "";
    public int $housenumber = 0;
    public ?string $housenumberExtension = null;
    public string $zipCode = "";
    public string $city = "";
    public int $country = Country::Netherlands->value;
    public bool $active = false;
    public int $type = AddressType::Shipping->value;

 



    public static function convertToModel(?address $entity): ?AddressModel
    {
        if ($entity === null) {
            return null;
        }


        $model = new AddressModel();

        $model->id = $entity->id;
        $model->userId = $entity->userId;
        $model->street = $entity->street;
        $model->housenumber = $entity->housenumber;
        $model->housenumberExtension = $entity->housenumberExtension;
        $model->zipCode = $entity->zipCode;
        $model->city = $entity->city;
        $model->country = $entity->country;
        $model->active = $entity->active;
        $model->type = $entity->type;

        return $model;
    }

    public function convertToEntity(): Address
    {
        $entity = new Address();
        
        $entity->id = $this->id;
        $entity->userId = $this->userId;
        $entity->street = $this->street;
        $entity->housenumber = $this->housenumber;
        $entity->housenumberExtension = $this->housenumberExtension;
        $entity->zipCode = $this->zipCode;
        $entity->city = $this->city;
        $entity->country = $this->country;
        $entity->active = $this->active;
        $entity->type = $this->type;

        return $entity;
    }
}
