<?php

namespace Http\Controllers\ControlPanel;

use Lib\Enums\SortOrder;
use Lib\MVCCore\Application;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\JsonResponse;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\TextResponse;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Models\BrandModel;
use Service\BrandService;
use Validators\Validate;

class ManageBrandsController extends Controller
{
    public function show(): ?Response
    {
        $response = new ViewResponse();

        $response->setBody(view(VIEWS_PATH . '/ControlPanel/ManageBrands.view.php')->withLayout(CONTROLPANEL_LAYOUT));

        return $response;
    }

    public function getBrandsTableData(): ?Response
    {
        $params = $this->currentRequest->urlQueryParams();
        $search = $params['search'];
        $offset = $params['offset'];
        $limit = $params['limit'];
        $sort = $params['sort'];
        $order = SortOrder::from($params['order'] == "" ? "asc" : $params['order']);

        /**
         * @var BrandService $brandService
         */
        $brandService = Application::resolve(BrandService::class);

        $brands = $brandService->getBrands($sort, $order);

        if ($brands === null) {
            $response = new JsonResponse();
            $response->setBody([
                "total" => 0,
                "rows" => []
            ]);
            return $response;
        }

        $brandsJson = [];
        foreach ($brands as $brand) {
            $brandJson = (array) $brand;
            $brandJson['active'] = $brand->active ? "Actief" : "Inactief";

            if (stristr(implode(' ', $brandJson), $search)) {
                $brandsJson[] = $brandJson;
            }
        }

        $brandJsons = array_slice($brandsJson, $offset, $limit);

        $response = new JsonResponse();

        $response->setBody([
            "total" => count($brandsJson),
            "rows" => $brandJsons
        ]);

        return $response;
    }

    public function addBrand(): ?Response
    {
        $brandService = Application::resolve(BrandService::class);

        $postBody = $this->currentRequest->postObject->body();

        $errors = $this->validateAddBrand($postBody);

        if (count($errors) > 0) {
            $response = new JsonResponse();
            $response->setBody($errors);
            return $response;
        }

        $newBrand = new BrandModel();

        $newBrand->name = $postBody['addName'];
        $newBrand->description = $postBody['addDescription'];
        $newBrand->active = $postBody['addActive'] === "true";

        $success = $brandService->addBrand($newBrand);

        $response = new TextResponse();

        $response->setBody($success ? "Brand added" : "Brand not added");

        return $response;
    }

    public function updateBrand(): ?Response
    {
        $brandService = Application::resolve(BrandService::class);

        $postBody = $this->currentRequest->postObject->body();

        $errors = $this->validateUpdateBrand($postBody);

        if (count($errors) > 0) {
            $response = new JsonResponse();
            $response->setBody($errors);
            return $response;
        }

        $toUpdateBrand = $brandService->getBrandById((int)$postBody['editId']);

        $toUpdateBrand->name = $postBody['editName'];
        $toUpdateBrand->description = $postBody['editDescription'];
        $toUpdateBrand->active = $postBody['editActive'] === "true";

        $success = $brandService->updateBrand($toUpdateBrand);

        $response = new TextResponse();

        $response->setBody($success ? "Brand updated" : "Brand not updated");

        return $response;
    }

    private function validateUpdateBrand($body): array
    {
        $errors = [];

        if (!Validate::notEmpty($body['editId'])) {
            $errors[] = ['field' => "editId", 'message' => "Id mag niet leeg zijn"];
        }

        if (Validate::notEmpty($body['editId']) && !Validate::isNumber($body['editId'])) {
            $errors[] = ['field' => "editId", 'message' => "Id moet een getal zijn"];
        }

        if (!Validate::notEmpty($body['editName'])) {
            $errors[] = ["field" => "editName", "message" => "Naam mag niet leeg zijn."];
        }

        if (!Validate::notEmpty($body['editDescription'])) {
            $errors[] = ["field" => "editDescription", "message" => "Beschrijving mag niet leeg zijn."];
        }

        if (!Validate::notEmpty($body['editActive'])) {
            $errors[] = ["field" => "editActive", "message" => "Actief mag niet leeg zijn."];
        }

        return $errors;
    }

    private function validateAddBrand($body): array
    {
        $errors = [];

        if (!Validate::notEmpty($body['addName'])) {
            $errors[] = ["field" => "addName", "message" => "Naam mag niet leeg zijn."];
        }

        if (!Validate::notEmpty($body['addDescription'])) {
            $errors[] = ["field" => "addDescription", "message" => "Beschrijving mag niet leeg zijn."];
        }

        if (!Validate::notEmpty($body['addActive'])) {
            $errors[] = ["field" => "addActive", "message" => "Actief mag niet leeg zijn."];
        }

        return $errors;
    }
}
