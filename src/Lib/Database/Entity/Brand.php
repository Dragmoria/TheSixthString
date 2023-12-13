<?php

namespace Lib\Database\Entity;

class Brand extends SaveableObject {
    public function __construct() {
        parent::__construct("brand");
    }

    public string $name = "";
    public string $description = "";
    public bool $active = false;
}