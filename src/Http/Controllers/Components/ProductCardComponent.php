<?php

namespace Http\Controllers\Components;

use Lib\MVCCore\Component;
use Models\ProductModel;

class ProductCardComponent implements Component {
    public function get(?array $data): string
    {
        $product = cast(ProductModel::class, $data);

        return view(VIEWS_PATH . 'Components/ProductCard.component.php', [
            "product" => $product
        ])->render();
    }
}