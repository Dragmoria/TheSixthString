<?php

namespace Http\Controllers\Components;

use Lib\MVCCore\Application;
use Service\CategoryService;

class CategoryListComponent {
    public function get(?array $data): string
    {
        $categories = Application::resolve(CategoryService::class)->getActiveCategoriesWithChildren();

        return view(VIEWS_PATH . 'Components/CategoryList.component.php', [
            "categories" => $categories
        ])->render();
    }
}