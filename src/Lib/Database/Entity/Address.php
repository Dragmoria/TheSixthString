<?php

namespace Lib\Database\Entity;

class Address extends SaveableObject {
    public function __construct() {
        parent::__construct("address");
    }

    public int $userId = 0;
    public string $street = "";
    public int $housenumber = 0;
    public ?string $housenumberExtension = null;
    public string $zipCode = "";
    public string $city = "";
    public int $country = 0;
    public bool $active = false;
    public int $type = 0; //default is AddressType::Invoice (= 0)
}