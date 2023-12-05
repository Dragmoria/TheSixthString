<?php

namespace Database\Entity;

use Shared\Enums\Role;
use Shared\Enums\Gender;

class User extends SaveableObject {

    function __construct() {
        $this->id = 0;
        $this->emailaddress = "";
        $this->passwordHash = "";
        $this->role = Role::User;
        $this->firstName = "";
        $this->insertion = null;
        $this->lastName = "";
        $this->dateOfBirth = null;
        $this->gender = Gender::Unknown;
        $this->active = false;
        $this->createdOn = new \DateTime();
    }

    public string $emailaddress;
    public string $passwordHash;
    public Role $role;
    public string $firstName;
    public ?string $insertion;
    public string $lastName;
    public ?\DateTime $dateOfBirth;
    public Gender $gender;
    public bool $active;
    public \DateTime $createdOn;
}