<?php

namespace Http\Controllers;

use Lib\MVCCore\Application;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Service\CategoryService;

class CategoryController extends Controller {
    public function index($data): ?Response {
        $response = new ViewResponse();

        $categories = Application::resolve(CategoryService::class)->getActiveCategories($data["id"] ?? null);

        if($this->hasChildCategoriesForSelectedCategory($categories)) {
            $response->setBody(view(VIEWS_PATH . 'Categories.view.php', ['categories' => $categories])->withLayout(MAIN_LAYOUT));
        } else {
            redirect("/Product?category=" . $data["id"]);
        }

        return $response;
    }

    private function hasChildCategoriesForSelectedCategory(array $categories): bool {
        return count(array_filter($categories, fn($category) => !$category->isSelectedCategory)) > 0;
    }
}