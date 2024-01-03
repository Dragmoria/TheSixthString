<?php

namespace Http\Controllers\ControlPanel;

use Lib\MVCCore\Application;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\JsonResponse;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Models\AdminProductFilterModel;
use Service\BrandService;
use Service\CategoryService;
use Service\ProductService;

class ManageProductsController extends Controller
{
    public function show(): ?Response
    {
        $response = new ViewResponse();

        $response->setBody(view(VIEWS_PATH . 'ControlPanel/ManageProducts.view.php', [])->withLayout(CONTROLPANEL_LAYOUT));

        return $response;
    }

    public function addProduct(): ?Response
    {
        $postBody = $this->currentRequest->postObject->body();
        $postBody["addFiles"] = $this->currentRequest->postObject->files();
        $errors = $this->validateAddProduct($postBody);

        if (count($errors) > 0) {
            $response = new JsonResponse();
            $response->setBody($errors);
            return $response;
        }

        dumpDie($postBody);
    }

    private function validateAddProduct($body): ?array
    {
        // TODO: Implement validateAddProduct() method.
        return [];
    }

    public function editProduct(): ?Response
    {
        $postBody = $this->currentRequest->postObject->body();
        $postBody["addFiles"] = $this->currentRequest->postObject->files();
        $errors = $this->validateEditProduct($postBody);

        if (count($errors) > 0) {
            $response = new JsonResponse();
            $response->setBody($errors);
            return $response;
        }

        // TODO: Implement editProduct() method.
        // Make sure to check for files that have not been changed
        // Deleting can be skipped just dont add them to the json in the db
        // If a file that was already in the json was posted with some key it should be kept but not saved again
        // If it is a new file add it to the json aswell and save it to the images folder
    }

    private function validateEditProduct($body): ?array
    {
        // TODO: Implement validateEditProduct() method.
        return [];
    }

    public function getBrands(): ?Response
    {
        $brandService = Application::resolve(BrandService::class);

        $brands = $brandService->getActiveBrands();

        $response = new JsonResponse();
        $response->setBody($brands);

        return $response;
    }

    public function getCategories(): ?Response
    {
        $categoryService = Application::resolve(CategoryService::class);

        $categories = $categoryService->getAllCategories(true);

        $response = new JsonResponse();
        $response->setBody($this->convertCategoriesToViewReadable($categories));

        return $response;
    }

    public function getProductsTableData(): ?Response
    {
        $params = $this->currentRequest->urlQueryParams();
        $offset = $params['offset'];
        $limit = $params['limit'];

        $productFilter = new AdminProductFilterModel();
        $productFilter->name = trim($params['search']) == "" ? null : $params['search'];
        $productFilter->categoryId = trim($params['categoryId']) == "null" ? null : (int)$params['categoryId'];
        $productFilter->brandId = trim($params['brandId']) == "null" ? null : (int)$params['brandId'];
        $productFilter->sku = trim($params['sku']) == "" ? null : $params['sku'];

        if ($params['status'] == "null") {
            $productFilter->active = null;
        } else if ($params['status'] == "Active") {
            $productFilter->active = true;
        } else {
            $productFilter->active = false;
        }

        $productService = Application::resolve(ProductService::class);

        $products = $productService->getAllProducts($productFilter);

        $productsJson = [];
        foreach ($products as $product) {
            $productJson = (array) $product;
            if ($productJson['media'] !== null) {
                $productJson['thumbnail'] = $product->media->thumbnail->url;
            } else {
                $productJson['thumbnail'] = "";
            }

            $productsJson[] = $productJson;
        }


        $productsJson = array_slice($productsJson, $offset, $limit);

        $response = new JsonResponse();
        $response->setBody($productsJson);

        return $response;
    }

    private function convertCategoriesToViewReadable(array $categories): array
    {
        $returnArray = [];

        foreach ($categories as $category) {
            $returnArray[] = ["name" => $this->getCategoryName($category), "id" => $category->id];
        }

        return $returnArray;
    }

    private function getCategoryName($category): string
    {
        if ($category->parentCategory !== null) {
            return $this->getCategoryName($category->parentCategory) . '>>' . $category->name;
        } else {
            return $category->name;
        }
    }
}
