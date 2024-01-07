<?php

namespace Models;

class AdminProductFilterModel extends ProductFilterModel
{
    public ?bool $active = null;
    public ?string $name = null;
    public ?string $sku = null;
}
