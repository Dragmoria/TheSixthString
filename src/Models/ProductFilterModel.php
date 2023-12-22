<?php

namespace Models;

use Lib\Enums\SortType;

class ProductFilterModel {
    public ?int $categoryId = null;
    public ?int $brandId = null;
    public ?bool $isInStock = true;
    public ?int $minPrice = 0;
    public ?int $maxPrice = 25000;
    public ?SortType $sortOrder = SortType::PriceAsc;
}