<?php

namespace Http\Controllers\ControlPanel;

use Lib\Helpers\TaxHelper;
use Lib\MVCCore\Application;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\JsonResponse;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Models\AdminProductFilterModel;
use Models\BrandModel;
use Models\CategoryModel;
use Models\MediaElementModel;
use Models\MediaModel;
use Models\ProductModel;
use Service\BrandService;
use Service\CategoryService;
use Service\ProductService;
use Validators\Validate;

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
        try {
            $postBody = $this->currentRequest->postObject->body();
            $postBody["addFiles"] = $this->currentRequest->postObject->files();
            $errors = $this->validateAddProduct($postBody);

            if (count($errors) > 0) {
                $response = new JsonResponse();
                $response->setBody(["success" => false, "message" => $errors]);
                return $response;
            }

            $newProduct = new ProductModel();
            $newProduct->name = $postBody['name'];
            $newProduct->subtitle = $postBody['subtitle'];
            $newProduct->description = $postBody['description'];
            $newProduct->active = $postBody['status'] == "Active" ? true : false;
            $newProduct->amountInStock = $postBody['stock'];
            $newProduct->demoAmountInStock = $postBody['demoStock'];
            $newProduct->unitPrice = $postBody['price'];
            $newProduct->recommendedUnitPrice = $postBody['recommendedPrice'];
            $newProduct->sku = $postBody['sku'];

            //dumpDie($newProduct);
            $brand = new BrandModel();
            $brand->id = (int)$postBody['brand'];
            $newProduct->brand = $brand;

            $category = new CategoryModel();
            $category->id = (int)$postBody['category'];
            $newProduct->category = $category;

            $media = new MediaModel();

            $thumbnailFile = $this->saveFile($postBody['addFiles']['thumbnail']);

            $thumbnail = new MediaElementModel(
                "Image",
                $thumbnailFile
            );

            $media->thumbnail = $thumbnail;

            $mainImageFile = $this->saveFile($postBody['addFiles']['mainImage']);

            $mainImage = new MediaElementModel(
                "Image",
                $mainImageFile
            );

            $media->mainImage = $mainImage;

            $productImages = [];

            $productImagesData = $postBody['addFiles']['productImages'];
            for ($i = 0; $i < count($productImagesData['name']); $i++) {
                $productImage = [
                    'name' => $productImagesData['name'][$i],
                    'full_path' => $productImagesData['full_path'][$i],
                    'type' => $productImagesData['type'][$i],
                    'tmp_name' => $productImagesData['tmp_name'][$i],
                    'error' => $productImagesData['error'][$i],
                    'size' => $productImagesData['size'][$i],
                ];

                $productImageFile = $this->saveFile($productImage);

                $productImages[] = new MediaElementModel(
                    "Image",
                    $productImageFile
                );
            }

            $media->secondaryImages = $productImages;

            $video = new MediaElementModel(
                "Video",
                $postBody['video']
            );

            $media->video = $video;

            $newProduct->media = $media;

            $productService = Application::resolve(ProductService::class);

            $res = $productService->addProduct($newProduct);

            $response = new JsonResponse();
            $response->setBody(["success" => $res]);
            return $response;
        } catch (\Exception $e) {
            $response = new JsonResponse();
            $response->setBody(["success" => false, "message" => $e->getMessage()]);
            return $response;
        }
    }

    private function saveFile($file): ?string
    {
        $fileName = uniqid() . "-" . basename($file["name"]);

        $targetDir = BASE_PATH . "/public/images/products/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return "/images/products/" . $fileName;
        } else {
            throw new \Exception("Failed to save file: " . $file["name"]);
        }
    }

    private function validateAddProduct($body): array
    {
        $errors = [];

        if (!Validate::notEmpty($body["name"])) {
            $errors[] = ["field" => "name", "message" => "Naam mag niet leeg zijn."];
        }

        if (!Validate::notEmpty($body["subtitle"])) {
            $errors[] = ["field" => "subtitle", "message" => "Subtitle mag niet leeg zijn."];
        }

        if (!Validate::notEmpty($body["description"])) {
            $errors[] = ["field" => "description", "message" => "Beschrijving mag niet leeg zijn."];
        }

        if (!Validate::notEmpty($body["status"])) {
            $errors[] = ["field" => "status", "message" => "Status mag niet leeg zijn."];
        }

        if (!Validate::notEmpty($body["stock"])) {
            $errors[] = ["field" => "stock", "message" => "Stock mag niet leeg zijn."];
        } else {
            if (!Validate::isNumber($body["stock"])) {
                $errors[] = ["field" => "stock", "message" => "Stock moet een nummer zijn."];
            }
        }

        if (!Validate::notEmpty($body["demoStock"])) {
            $errors[] = ["field" => "demoStock", "message" => "Demo stock mag niet leeg zijn."];
        } else {
            if (!Validate::isNumber($body["demoStock"])) {
                $errors[] = ["field" => "demoStock", "message" => "Demo stock moet een nummer zijn."];
            }
        }

        if (!Validate::notEmpty($body["price"])) {
            $errors[] = ["field" => "price", "message" => "Prijs mag niet leeg zijn."];
        } else {
            if (!Validate::isNumber($body["price"])) {
                $errors[] = ["field" => "price", "message" => "Prijs moet een nummer zijn."];
            }
        }

        if (!Validate::notEmpty($body["recommendedPrice"])) {
            $errors[] = ["field" => "recommendedPrice", "message" => "Aanbevolen prijs mag niet leeg zijn."];
        } else {
            if (!Validate::isNumber($body["recommendedPrice"])) {
                $errors[] = ["field" => "recommendedPrice", "message" => "Aanbevolen prijs moet een nummer zijn."];
            }
        }

        if (!Validate::notEmpty($body["sku"])) {
            $errors[] = ["field" => "sku", "message" => "Sku mag niet leeg zijn."];
        }

        if (!Validate::notEmpty($body["brand"])) {
            $errors[] = ["field" => "brand", "message" => "Brand mag niet leeg zijn."];
        }

        if (!Validate::notEmpty($body["category"])) {
            $errors[] = ["field" => "category", "message" => "Categorie mag niet leeg zijn."];
        }

        if (!isset($body['addFiles']['thumbnail'])) {
            $errors[] = ["field" => "thumbnail", "message" => "Thumbnail mag niet leeg zijn."];
        }

        if (!isset($body['addFiles']['mainImage'])) {
            $errors[] = ["field" => "mainImage", "message" => "Main image mag niet leeg zijn."];
        }

        if (!isset($body['addFiles']['productImages'])) {
            $errors[] = ["field" => "productImages", "message" => "Product images mag niet leeg zijn."];
        }

        if (!Validate::notEmpty($body["video"])) {
            $errors[] = ["field" => "video", "message" => "Video mag niet leeg zijn."];
        }

        return $errors;
    }

    public function updateProduct(): ?Response
    {
        try {
            $postBody = $this->currentRequest->postObject->body();
            $postBody["addFiles"] = $this->currentRequest->postObject->files();
            $errors = $this->validateEditProduct($postBody);

            if (count($errors) > 0) {
                $response = new JsonResponse();
                $response->setBody($errors);
                return $response;
            }

            $productService = Application::resolve(ProductService::class);

            $toUpdateProduct = $productService->getProductDetails((int)$postBody['id']);
            $toUpdateProduct->name = $postBody['name'];
            $toUpdateProduct->subtitle = $postBody['subtitle'];
            $toUpdateProduct->description = $postBody['description'];
            $toUpdateProduct->active = $postBody['status'] == "Active" ? true : false;
            $toUpdateProduct->amountInStock = $postBody['stock'];
            $toUpdateProduct->demoAmountInStock = $postBody['demoStock'];
            $toUpdateProduct->unitPrice = $postBody['price'];
            $toUpdateProduct->recommendedUnitPrice = $postBody['recommendedPrice'];
            $toUpdateProduct->sku = $postBody['sku'];
            $toUpdateProduct->brand = new BrandModel();
            $toUpdateProduct->brand->id = (int)$postBody['brand'];
            $toUpdateProduct->category = new CategoryModel();
            $toUpdateProduct->category->id = (int)$postBody['category'];

            $media = new MediaModel();

            if ($postBody['oldThumbnail'] === "undefined") {
                $thumbnailFile = $this->saveFile($postBody['addFiles']['thumbnail']);

                $thumbnail = new MediaElementModel(
                    "Image",
                    $thumbnailFile
                );

                $media->thumbnail = $thumbnail;
            } else {
                $media->thumbnail = new MediaElementModel(
                    "Image",
                    $postBody['oldThumbnail']
                );
            }

            if ($postBody['oldMainImage'] === "undefined") {
                $mainImageFile = $this->saveFile($postBody['addFiles']['mainImage']);

                $mainImage = new MediaElementModel(
                    "Image",
                    $mainImageFile
                );

                $media->mainImage = $mainImage;
            } else {
                $media->mainImage = new MediaElementModel(
                    "Image",
                    $postBody['oldMainImage']
                );
            }

            $productImages = [];

            if (isset($postBody['addFiles']['editProductImages'])) {
                $productImagesData = $postBody['addFiles']['editProductImages'];
                for ($i = 0; $i < count($productImagesData['name']); $i++) {
                    $productImage = [
                        'name' => $productImagesData['name'][$i],
                        'full_path' => $productImagesData['full_path'][$i],
                        'type' => $productImagesData['type'][$i],
                        'tmp_name' => $productImagesData['tmp_name'][$i],
                        'error' => $productImagesData['error'][$i],
                        'size' => $productImagesData['size'][$i],
                    ];

                    $productImageFile = $this->saveFile($productImage);

                    $productImages[] = new MediaElementModel(
                        "Image",
                        $productImageFile
                    );
                }
            }

            $oldImages = explode(",", $postBody['oldProductImages']);
            foreach ($oldImages as $oldImage) {
                if ($oldImage !== "") {
                    $productImages[] = new MediaElementModel(
                        "Image",
                        $oldImage
                    );
                }
            }

            $video = new MediaElementModel(
                "Video",
                $postBody['video']
            );

            $media->video = $video;

            $media->secondaryImages = $productImages;

            $toUpdateProduct->media = $media;

            $res = $productService->updateProduct($toUpdateProduct);

            $response = new JsonResponse();
            $response->setBody(["success" => $res]);
            return $response;
        } catch (\Exception $e) {
            $response = new JsonResponse();
            $response->setBody(["success" => false, "message" => $e->getMessage()]);
            return $response;
        }
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
            $product->unitPrice = round($product->unitPrice, 2);
            $product->recommendedUnitPrice = round($product->recommendedUnitPrice, 2);
            if (!empty($product->media->secondaryImages)) {
                array_shift($product->media->secondaryImages);
            }
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
