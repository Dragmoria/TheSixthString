<?php

namespace Lib\Database\Entity;

class Category extends SaveableObject {
    public function __construct() {
        parent::__construct("category");
    }

    public string $name = "";
    public string $description = "";
    public ?int $parentId = null;
    public bool $active = false;
    public ?string $media = null;
}