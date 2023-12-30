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

// TODO: add search and pagination from bootstrap table
// TODO: add edit and delete functionality
// TODO: vraag @iris of categorieën 3 of meer diep ook werkt

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
        $categoryService = Application::resolve(CategoryService::class);

        $t = $categoryService->getAllCategories();

        $response = new JsonResponse();

        $response->setBody($this->convertCategoriesToViewReadable($t));

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

        // Move the uploaded file to the target directory
        if (!move_uploaded_file($file["tmp_name"], $targetFile)) {
            // Add an error message if the file couldn't be saved
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
            $newCategory->parentCategory = $categoryService->getById((int)$postBody['addParentCategory']);
        }
        //json_encode
        $success = $categoryService->addCategory($newCategory);

        $response = new TextResponse();

        $response->setBody($success ? "Category added" : "Category not added");

        return $response;
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
