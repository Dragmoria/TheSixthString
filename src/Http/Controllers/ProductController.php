<?php

namespace Http\Controllers;

use Lib\MVCCore\Application;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Service\CategoryService;
use Service\ProductService;

class ProductController extends Controller {
    public function index(): ?Response {
        $response = new ViewResponse();

        $request = $this->currentRequest;
        $urlQueryParams = $request->urlQueryParams();
        $categoryId = $urlQueryParams["categoryId"] ?? null;

        if(!is_null($categoryId)) {
            //TODO: pre-select category-filter
        }

//        $products = Application::resolve(ProductService::class)->getProducts($urlQueryParams["id"] ?? null);
        $products = array();

        $response->setBody(view(VIEWS_PATH . 'Products.view.php', ['products' => $products])->withLayout(MAIN_LAYOUT));

        return $response;
    }

    public function details($id): ?Response {
        $response = new ViewResponse();

        $productDetails = Application::resolve(ProductService::class)->getProductDetails((int)$id);

        $response->setBody(view(VIEWS_PATH . 'ProductDetails.view.php', ['data' => $productDetails])->withLayout(MAIN_LAYOUT));

        return $response;
    }
}