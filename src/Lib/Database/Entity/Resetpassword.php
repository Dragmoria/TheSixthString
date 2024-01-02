<?php

namespace Lib\Database\Entity;

class Resetpassword extends SaveableObject
{
    public function __construct()
    {
        parent::__construct("resetpassword");
    }

    public int $userId = 0;
    public string $link = "";
    public string $validUntil = "";
}

