<?php

namespace Http\Controllers\Components;

use Lib\MVCCore\Component;

class ProductComponent implements Component {
    public function get(?array $data): string {
        return view(VIEWS_PATH . "Components/Product.component.php", [
            'id' => $data['id'],
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price']
        ])->render();
    }
}