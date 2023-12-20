<?php

namespace Http\Controllers;

use Lib\MVCCore\Application;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Service\CategoryService;

class CategoryController extends Controller {
    public function index(): ?Response {
        $response = new ViewResponse();

        $request = $this->currentRequest;
        $urlQueryParams = $request->urlQueryParams();

        $categories = Application::resolve(CategoryService::class)->getActiveCategories($urlQueryParams["id"] ?? null);

        if($this->hasChildCategoriesForSelectedCategory($categories)) {
            $response->setBody(view(VIEWS_PATH . 'Categories.view.php', ['categories' => $categories])->withLayout(MAIN_LAYOUT));
        } else {
            redirect("/Product?categoryId=" . $urlQueryParams["id"]);
        }

        return $response;
    }

    private function hasChildCategoriesForSelectedCategory(array $categories): bool {
        return count(array_filter($categories, fn($category) => !$category->isSelectedCategory)) > 0;
    }
}