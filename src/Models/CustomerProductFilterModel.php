<?php

namespace Models;

use Lib\Enums\SortType;

class CustomerProductFilterModel extends ProductFilterModel
{
    public ?bool $isInStock = true;
    public ?int $minPrice = 0;
    public ?int $maxPrice = 25000;
    public ?SortType $sortOrder = SortType::PriceAsc;
    public ?string $search = null;
}
