<?php

namespace Http\Controllers\ControlPanel;

use Lib\MVCCore\Application;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\JsonResponse;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\TextResponse;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Models\MediaModel;
use Models\SimpleCategoryModel;
use Service\CategoryService;
use Validators\Validate;

class ManageCategoriesController extends Controller
{
    public function show(): ?Response
    {
        $response = new ViewResponse();

        $response->setBody(view(VIEWS_PATH . 'ControlPanel/ManageCategories.view.php')->withLayout(CONTROLPANEL_LAYOUT));

        return $response;
    }

    public function getCategoriesTableData()
    {
        $params = $this->currentRequest->urlQueryParams();
        $search = $params['search'];
        $offset = $params['offset'];
        $limit = $params['limit'];

        $categoryService = Application::resolve(CategoryService::class);

        $categories = $categoryService->getAllCategories();

        $categories = $this->convertCategoriesToViewReadable($categories);

        $categoriesJson = [];
        foreach ($categories as $category) {
            $categorieJson = (array) $category;
            unset($categorieJson["media"]);

            if (stristr(implode(' ', $categorieJson), $search)) {
                $categoriesJson[] = $categorieJson;
            }
        }

        $categoriesJson = array_slice($categoriesJson, $offset, $limit);

        $response = new JsonResponse();

        $response->setBody($categoriesJson);

        return $response;
    }

    public function addCategory(): ?Response
    {
        $categoryService = Application::resolve(CategoryService::class);

        $postBody = $this->currentRequest->postObject->body();
        $postBody["addFiles"] = $this->currentRequest->postObject->files();
        $errors = $this->validateAddCategory($postBody);

        if (count($errors) > 0) {
            $response = new JsonResponse();
            $response->setBody($errors);
            return $response;
        }

        $newCategory = new SimpleCategoryModel();

        $newCategory->name = $postBody['addName'];
        $newCategory->description = $postBody['addDescription'];
        $newCategory->active = $postBody['addActive'] === "true";

        $file = $postBody["addFiles"]["addImage"];

        $fileName = uniqid() . "-" . basename($file["name"]);

        $targetDir = BASE_PATH . "/public/images/categories/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $targetFile = $targetDir . $fileName;

        if (!move_uploaded_file($file["tmp_name"], $targetFile)) {
            $errors[] = ["field" => "addFiles", "message" => "Failed to save file: " . $file["name"]];
        } else {
            $json = json_encode([
                "thumbnail" => [
                    "title" => "",
                    "url" => "/images/categories/" . $fileName,
                ],
                "mainImage" => null,
                "video" => null,
                "secondaryImages" => array()
            ], JSON_PRETTY_PRINT);

            $newCategory->media = MediaModel::convertToModel($json);
        }

        if ($postBody['addParentCategory'] !== "none") {
            $newCategory->parentCategory = $categoryService->getById((int) $postBody['addParentCategory']);
        }
        //json_encode
        $success = $categoryService->addCategory($newCategory);

        $response = new TextResponse();

        $response->setBody($success ? "Category added" : "Category not added");

        return $response;
    }

    public function updateCategory(): ?Response
    {
        $categoryService = Application::resolve(CategoryService::class);

        $postBody = $this->currentRequest->postObject->body();
        $postBody["editFiles"] = $this->currentRequest->postObject->files();
        $errors = $this->validateUpdateCategory($postBody);

        if (count($errors) > 0) {
            $response = new JsonResponse();
            $response->setBody($errors);
            return $response;
        }

        $toUpdateCategory = $categoryService->getById((int) $postBody['editId']);

        $toUpdateCategory->name = $postBody['editName'];
        $toUpdateCategory->description = $postBody['editDescription'];
        $toUpdateCategory->active = $postBody['editActive'] === "true";

        if ($postBody['editParentCategory'] !== "none") {
            $toUpdateCategory->parentCategory = $categoryService->getById((int) $postBody['editParentCategory']);
        }

        if (isset($postBody["editFiles"]["editImage"])) {
            $file = $postBody["editFiles"]["editImage"];

            $fileName = uniqid() . "-" . basename($file["name"]);

            $targetDir = BASE_PATH . "/public/images/categories/";
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $targetFile = $targetDir . $fileName;

            if (!move_uploaded_file($file["tmp_name"], $targetFile)) {
                $errors[] = ["field" => "editFiles", "message" => "Failed to save file: " . $file["name"]];
            } else {
                $json = json_encode([
                    "thumbnail" => [
                        "title" => "",
                        "url" => "/images/categories/" . $fileName,
                    ],
                    "mainImage" => null,
                    "video" => null,
                    "secondaryImages" => array()
                ], JSON_PRETTY_PRINT);

                $toUpdateCategory->media = MediaModel::convertToModel($json);
            }
        }

        $success = $categoryService->updateCategory($toUpdateCategory);

        $response = new TextResponse();

        $response->setBody($success ? "Category updated" : "Category not updated");

        return $response;
    }

    private function validateUpdateCategory($body): array
    {
        $errors = [];

        if (!Validate::notEmpty($body["editId"])) {
            $errors[] = ["field" => "editId", "message" => "Id mag niet leeg zijn."];
        }

        if (!Validate::notEmpty($body["editName"])) {
            $errors[] = ["field" => "editName", "message" => "Naam mag niet leeg zijn."];
        }

        if (!Validate::notEmpty($body["editDescription"])) {
            $errors[] = ["field" => "editDescription", "message" => "Beschrijving mag niet leeg zijn."];
        }

        if (!Validate::notEmpty($body["editActive"])) {
            $errors[] = ["field" => "editActive", "message" => "Actief mag niet leeg zijn."];
        }

        if (!isset($body["editFiles"]["editImage"])) {
            $errors[] = ["field" => "editImage", "message" => "Image mag niet leeg zijn."];
        }

        return $errors;
    }

    private function validateAddCategory($body): array
    {
        $errors = [];

        if (!Validate::notEmpty($body["addName"])) {
            $errors[] = ["field" => "addName", "message" => "Naam mag niet leeg zijn."];
        }

        if (!Validate::notEmpty($body["addDescription"])) {
            $errors[] = ["field" => "addDescription", "message" => "Beschrijving mag niet leeg zijn."];
        }

        if (!Validate::notEmpty($body["addActive"])) {
            $errors[] = ["field" => "addActive", "message" => "Actief mag niet leeg zijn."];
        }

        if (!isset($body["addFiles"]["addImage"])) {
            $errors[] = ["field" => "addImage", "message" => "Image mag niet leeg zijn."];
        }

        return $errors;
    }

    private function convertCategoriesToViewReadable(array $t): array
    {
        $categories = [];
        foreach ($t as $category) {
            $categoryJson = (array) $category;
            $categoryJson['displayName'] = $this->getCategoryName($category);
            $categoryJson['active'] = $category->active ? "Actief" : "Inactief";
            $categoryJson['thumbnail'] = $category->media === null ? "Geen" : $category->media->thumbnail->url;
            $categoryJson['parentCategory'] = $category->parentCategory === null ? "none" : $this->getCategoryName($category->parentCategory);
            $categoryJson["parentCategoryId"] = $category->parentCategory === null ? "none" : $category->parentCategory->id;
            $categories[] = $categoryJson;
        }

        return $categories;
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
