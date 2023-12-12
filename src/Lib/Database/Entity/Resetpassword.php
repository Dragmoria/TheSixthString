<?php

namespace Lib\Database\Entity;

class Resetpassword extends SaveableObject
{
    public function __construct()
    {
        $this->tableName = "resetpassword";
    }

    public int $userId = 0;
    public string $link = "";
    public string $validUntil = "";
}
