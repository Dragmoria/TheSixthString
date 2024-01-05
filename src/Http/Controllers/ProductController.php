<?php

namespace Http\Controllers;

use Lib\Enums\SortType;
use Lib\MVCCore\Application;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\JsonResponse;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Models\MediaElementModel;
use Models\ProductFilterModel;
use Models\ReviewModel;
use Service\BrandService;
use Service\CategoryService;
use Service\OrderService;
use Service\ProductService;
use Service\ReviewService;

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

        $productService = Application::resolve(ProductService::class);
        $productService->setProductVisited((int)$data["id"], $_SESSION["sessionUserGuid"]);
        $productDetails = $productService->getProductDetails((int)$data["id"]);

        $canWriteReview = false;
        if(isset($_SESSION["user"])) {
            $canWriteReview = $this->canWriteReview((int)$data["id"]);
        }

        $response->setBody(view(VIEWS_PATH . 'ProductDetails.view.php',
            [
                "product" => $productDetails,
                "canWriteReview" => $canWriteReview
            ]
        )->withLayout(MAIN_LAYOUT));

        return $response;
    }

    public function getSuggestedProducts(): ?Response {
        $postBody = $this->currentRequest->postObject->body();

        $response = new JsonResponse();
        $result = new \stdClass();

        $result->products = Application::resolve(ProductService::class)->getSuggestedProducts($postBody["search"]);

        $response->setBody((array)$result);
        return $response;
    }

    public function createReview(): ?Response {
        $postBody = $this->currentRequest->postObject->body();
        $productId = (int)$postBody["productId"];

        $response = new JsonResponse();
        $result = new \stdClass();

        if(!$this->canWriteReview((int)$postBody["productId"])) {
            $result->success = false;
            $result->message = "Je moet dit product eerst kopen voordat je er een review over kunt schrijven en je kunt maximaal 1 review per product schrijven.";

            $response->setBody((array)$result);
            return $response;
        }

        $model = new ReviewModel();
        $model->rating = $postBody["rating"];
        $model->title = $postBody["title"];
        $model->content = $postBody["content"];

        $result->success = Application::resolve(ReviewService::class)->createReview($productId, $_SESSION["user"]["id"], $model);

        $response->setBody((array)$result);
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

        if(!empty($urlQueryParams["search"])) {
            $filterModel->search = $urlQueryParams["search"];
        }

        return $filterModel;
    }

    private function canWriteReview(int $productId): bool {
        $productReviewByUser = Application::resolve(ReviewService::class)->getWrittenReviewForProductAndUser($productId, $_SESSION["user"]["id"]);
        $canWriteReview = Application::resolve(OrderService::class)->hasBoughtProduct($productId, $_SESSION["user"]["id"]);
        $canWriteReview &= is_null($productReviewByUser);

        return $canWriteReview;
    }
}