<?php

namespace Lib\Database\Entity;

class Brand extends SaveableObject {
    public function __construct() {
        $this->tableName = "brand";
    }

    public string $name = "";
    public string $description = "";
    public bool $active = false;
}