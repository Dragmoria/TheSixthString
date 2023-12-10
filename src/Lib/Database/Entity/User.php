<?php

namespace Lib\Database\Entity;

class User extends SaveableObject {
    function __construct() {
        $this->tableName = "user";

        $this->emailaddress = "";
        $this->passwordHash = "";
        $this->role = 0;
        $this->firstName = "";
        $this->insertion = null;
        $this->lastName = "";
        $this->dateOfBirth = null;
        $this->gender = 0;
        $this->active = false;
        $this->createdOn = new \DateTime();
    }

    public string $emailaddress;
    public string $passwordHash;
    public int $role; //default is Role::Customer (= 0)
    public string $firstName;
    public ?string $insertion;
    public string $lastName;
    public ?\DateTime $dateOfBirth;
    public int $gender; //default is Gender::Unknown (= 0)
    public bool $active;
    public \DateTime $createdOn;
}