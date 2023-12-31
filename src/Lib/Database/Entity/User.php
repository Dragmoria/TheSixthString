<?php

namespace Lib\Database\Entity;

class User extends SaveableObject
{
    function __construct()
    {
        parent::__construct("user");
    }

    public string $emailAddress = "";
    public string $passwordHash = "";
    public int $role = 0; //default is Role::Customer (= 0)
    public string $firstName = "";
    public ?string $insertion = null;
    public string $lastName = "";
    public ?string $dateOfBirth = null;
    public int $gender = 0; //default is Gender::Unknown (= 0)
    public bool $active = false;
    public string $createdOn = "";

    public ?string $activationLink = null;
    
    
}