<?php



namespace Models;

use Lib\Database\Entity\User;
use Lib\Enums\AddressType;


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
    public int $country = 0;
    public bool $active = false;
    public int $type = AddressType::Shipping->value;

}
