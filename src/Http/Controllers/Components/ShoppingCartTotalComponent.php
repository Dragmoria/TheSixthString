<?php

namespace Http\Controllers\Components;

use Lib\MVCCore\Component;
use Models\ShoppingCartModel;

class ShoppingCartTotalComponent implements Component {
    public function get(?array $data): string
    {
        return view(VIEWS_PATH . 'Components/ShoppingCartTotal.component.php', [
            "data" => cast(ShoppingCartModel::class, $data)
        ])->render();
    }
}