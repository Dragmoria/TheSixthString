<?php

namespace Http\Controllers;

use Lib\Enums\SortType;
use Lib\MVCCore\Application;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Models\MediaElementModel;
use Models\ProductFilterModel;
use Service\BrandService;
use Service\CategoryService;
use Service\ProductService;

class ProductController extends Controller {
    public function index(): ?Response {
        $response = new ViewResponse();

        $request = $this->currentRequest;
        $urlQueryParams = $request->urlQueryParams();

        $filterModel = $this->buildFilterModel($urlQueryParams);
        $products = Application::resolve(ProductService::class)->getProducts($filterModel);
        $categories = Application::resolve(CategoryService::class)->getActiveCategoriesWithChildren(['id', 'name', 'parentId']);
        $brands = Application::resolve(BrandService::class)->getActiveBrands();

        $filterData = new \stdClass();
        $filterData->categories = $categories;
        $filterData->brands = $brands;

        $response->setBody(view(VIEWS_PATH . 'Products.view.php',
            [
                'products' => $products,
                'selectedFilters' => $filterModel,
                'filterData' => $filterData
            ]
        )->withLayout(MAIN_LAYOUT));

        return $response;
    }

    public function details($data): ?Response {
        $response = new ViewResponse();

        $productDetails = Application::resolve(ProductService::class)->getProductDetails((int)$data["id"]);

        $response->setBody(view(VIEWS_PATH . 'ProductDetails.view.php',
            [
                "product" => $productDetails,
                "previousPage" => ""
            ]
        )->withLayout(MAIN_LAYOUT));

        return $response;
    }

    private function buildFilterModel(array $urlQueryParams): ProductFilterModel {
        $filterModel = new ProductFilterModel();

        $filterModel->categoryId = !empty($urlQueryParams["category"]) ? $urlQueryParams["category"] : null;
        $filterModel->brandId = !empty($urlQueryParams["brand"]) ? $urlQueryParams["brand"] : null;

        if(!empty($urlQueryParams["instock"])) {
            $filterModel->isInStock = $urlQueryParams["instock"] == "true";
        }

        if(!empty($urlQueryParams["minprice"])) {
            $filterModel->minPrice = (int)$urlQueryParams["minprice"];
        }

        if(!empty($urlQueryParams["maxprice"])) {
            $filterModel->maxPrice = (int)$urlQueryParams["maxprice"];
        }

        if(!empty($urlQueryParams["sortorder"])) {
            $filterModel->sortOrder = SortType::fromString($urlQueryParams["sortorder"]);
        }

        return $filterModel;
    }
}