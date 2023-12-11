<?php

namespace Lib\Database\Entity;

class Category extends SaveableObject {
    public function __construct() {
        $this->tableName = "category";
    }

    public string $name = "";
    public string $description = "";
    public ?int $parentId = null;
    public bool $active = false;
    public ?string $media = null;
}