<?php 

namespace Http\Controllers\Components;

use Lib\MVCCore\Component;

class PageButtonComponent implements Component {
    public function get(?array $data): string {
        return view(VIEWS_PATH . "Components/PageButton.component.php", [
            "path" => $data["path"],
            "enabled" => $data["enabled"],
            "text" => $data["text"],
            "icon" => $data["icon"],
            "onClick" => $data["onClick"]
        ])->render();
    }
}