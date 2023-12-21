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
    public int $userId = 0;
    public string $street = "";
    public int $housenumber = 0;
    public ?string $housenumberExtension = null;
    public string $zipCode = "";
    public string $city = "";
    public Country $country = Country::Netherlands;
    public bool $active = false;
    public int $type = AddressType::Shipping->value;





    public static function convertToModel(?address $entity): ?AddressModel
    {
        if ($entity->isEmptyObject()) return null;

        $model = new AddressModel();

        $model->userId = $entity->id;
        $model->street = $entity->street;
        $model->housenumber = $entity->housenumber;
        $model->housenumberExtension = $entity->housenumberExtension;
        $model->zipCode = $entity->zipCode;
        $model->city = $entity->city;
        $model->country = Country::Netherlands;
        $model->active = $entity->active;
        $model->type = $entity->type;

        return $model;
    }

    public function convertToEntity(): Address
    {
        $entity = new Address();

        $entity->id = $this->userId;
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
