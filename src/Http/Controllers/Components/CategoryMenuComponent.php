<?php

namespace Http\Controllers\Components;

use Lib\MVCCore\Application;
use Lib\MVCCore\Component;
use Service\CategoryService;

class CategoryMenuComponent implements Component {
    public function get(?array $data): string
    {
        $categories = Application::resolve(CategoryService::class)->getActiveCategoriesWithChildren();

        return view(VIEWS_PATH . 'Components/CategoryMenu.component.php', [
            "categories" => $categories
        ])->render();
    }
}