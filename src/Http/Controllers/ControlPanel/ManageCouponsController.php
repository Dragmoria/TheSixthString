<?php

namespace Http\Controllers\ControlPanel;

use Lib\Enums\CouponType;
use Lib\Enums\SortOrder;
use Lib\MVCCore\Application;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\JsonResponse;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\TextResponse;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Models\CouponModel;
use Service\CouponService;
use Validators\Validate;

class ManageCouponsController extends Controller
{
    public function show(): ?Response
    {
        $response = new ViewResponse();

        $response->setBody(view(VIEWS_PATH . 'ControlPanel/ManageCoupons.view.php', [])->withLayout(CONTROLPANEL_LAYOUT));

        return $response;
    }

    public function getCouponsTableData(): ?Response
    {
        $params = $this->currentRequest->urlQueryParams();
        $search = $params['search'];
        $offset = $params['offset'];
        $limit = $params['limit'];
        $sort = $params['sort'];
        $order = SortOrder::from($params['order'] == "" ? "asc" : $params['order']);

        $couponService = Application::resolve(CouponService::class);

        $coupons = $couponService->getCoupons($sort, $order);

        if ($coupons === null) {
            $response = new JsonResponse();
            $response->setBody([
                "total" => 0,
                "rows" => []
            ]);
            return $response;
        }

        $couponsJson = [];
        foreach ($coupons as $coupon) {
            $couponJson = (array) $coupon;
            $couponJson['startDate'] = $coupon->startDate->format('d-m-Y');
            $couponJson['endDate'] = $coupon->endDate === null ? "none" : $coupon->endDate->format('d-m-Y');
            $couponJson['type'] = $coupon->type->toString("nl");
            $couponJson['active'] = $coupon->active ? "Actief" : "Inactief";

            if (stristr(implode(' ', $couponJson), $search)) {
                $couponsJson[] = $couponJson;
            }
        }

        $couponsJson = array_slice($couponsJson, $offset, $limit);

        $response = new JsonResponse();

        $response->setBody([
            "total" => count($coupons),
            "rows" => $couponsJson
        ]);

        return $response;
    }

    public function updateCoupon(): ?Response
    {
        $couponService = Application::resolve(CouponService::class);

        $postBody = $this->currentRequest->postObject->body();

        $errors = $this->validateUpdateCoupon($postBody);

        if (count($errors) > 0) {
            $response = new JsonResponse();
            $response->setBody($errors);
            return $response;
        }

        $toUpdateCoupon = $couponService->getCouponById((int)$postBody['editId']);

        $toUpdateCoupon->name = $postBody['editName'];
        $toUpdateCoupon->code = $postBody['editCode'];
        $toUpdateCoupon->value = $postBody['editValue'];
        $toUpdateCoupon->endDate = $postBody['editEndDate'] === null ? null : new \DateTime($postBody['editEndDate']);
        $toUpdateCoupon->maxUsageAmount = $postBody['editMaxUsageAmount'];
        $toUpdateCoupon->active = $postBody['editActive'] == "true" ? true : false;
        $toUpdateCoupon->type = CouponType::fromString($postBody['editType']);

        $success = $couponService->updateCoupon($toUpdateCoupon);

        $response = new TextResponse();

        $response->setBody($success ? "Coupon updated" : "Coupon not updated");
        return $response;
    }

    public function addNewCoupon(): ?Response
    {
        $couponService = Application::resolve(CouponService::class);

        $postBody = $this->currentRequest->postObject->body();

        $errors = $this->validateNewCoupon($postBody);

        if (count($errors) > 0) {
            $response = new JsonResponse();
            $response->setBody($errors);
            return $response;
        }

        $newCoupon = new CouponModel();

        $newCoupon->name = $postBody['newName'];
        $newCoupon->code = $postBody['newCode'];
        $newCoupon->value = $postBody['newValue'];
        $newCoupon->startDate = new \DateTime($postBody['newStartDate']);
        $newCoupon->endDate = $postBody['newEndDate'] === null ? null : new \DateTime($postBody['newEndDate']);
        $newCoupon->maxUsageAmount = $postBody['newMaxUsageAmount'];
        $newCoupon->active = $postBody['newActive'] == "true" ? true : false;
        $newCoupon->type = CouponType::fromString($postBody['newType']);

        $success = $couponService->addCoupon($newCoupon);

        $response = new TextResponse();


        $response->setBody($success ? "Coupon added" : "Coupon not added");
        return $response;
    }

    private function validateNewCoupon(array $body): array
    {
        $errors = [];

        if (!Validate::notEmpty($body['newName'])) {
            $errors[] = ['field' => "newName", 'message' => "Naam mag niet leeg zijn"];
        }

        if (!Validate::notEmpty($body['newCode'])) {
            $errors[] = ['field' => "newCode", 'message' => "Code mag niet leeg zijn"];
        }

        if (!Validate::notEmpty($body['newValue'])) {
            $errors[] = ['field' => "newValue", 'message' => "Waarde mag niet leeg zijn"];
        }

        if (Validate::notEmpty($body['newValue']) && !Validate::isNumber($body['newValue'])) {
            $errors[] = ['field' => "newValue", 'message' => "Waarde moet een getal zijn"];
        }

        if (!Validate::dateString($body['newEndDate'])) {
            $errors[] = ['field' => "newEndDate", 'message' => "Eind datum is niet in geldig formaat"];
        }

        if (!Validate::dateString($body['newStartDate'])) {
            $errors[] = ['field' => "newStartDate", 'message' => "Start datum is niet in geldig formaat"];
        }

        if (!Validate::notEmpty($body['newStartDate'])) {
            $errors[] = ['field' => "newStartDate", 'message' => "Start datum mag niet leeg zijn"];
        }

        if (!Validate::notEmpty($body['newMaxUsageAmount'])) {
            $errors[] = ['field' => "newMaxUsageAmount", 'message' => "Maximale gebruiks hoeveelheid mag niet leeg zijn"];
        }

        if (Validate::notEmpty($body['newMaxUsageAmount']) && !Validate::isNumber($body['newMaxUsageAmount'])) {
            $errors[] = ['field' => "newMaxUsageAmount", 'message' => "Maximale gebruiks hoeveelheid moet een nummer zijn"];
        }

        if (!Validate::notEmpty($body['newType'])) {
            $errors[] = ['field' => "newType", 'message' => "Type mag niet leeg zijn"];
        }

        if (!Validate::notEmpty($body['newActive'])) {
            $errors[] = ['field' => "newActive", 'message' => "Actief mag niet leeg zijn"];
        }

        return $errors;
    }

    private function validateUpdateCoupon(array $body): array
    {
        $errors = [];

        if (!Validate::notEmpty($body['editId'])) {
            $errors[] = ['field' => "editId", 'message' => "Id mag niet leeg zijn"];
        }

        if (Validate::notEmpty($body['editId']) && !Validate::isNumber($body['editId'])) {
            $errors[] = ['field' => "editId", 'message' => "Id moet een getal zijn"];
        }

        if (!Validate::notEmpty($body['editName'])) {
            $errors[] = ['field' => "editName", 'message' => "Naam mag niet leeg zijn"];
        }

        if (!Validate::notEmpty($body['editCode'])) {
            $errors[] = ['field' => "editCode", 'message' => "Code mag niet leeg zijn"];
        }

        if (!Validate::notEmpty($body['editValue'])) {
            $errors[] = ['field' => "editValue", 'message' => "Waarde mag niet leeg zijn"];
        }

        if (Validate::notEmpty($body['editValue']) && !Validate::isNumber($body['editValue'])) {
            $errors[] = ['field' => "editValue", 'message' => "Waarde moet een getal zijn"];
        }

        if (!Validate::dateString($body['editEndDate'])) {
            $errors[] = ['field' => "editEndDate", 'message' => "Eind datum is niet in geldig formaat"];
        }

        if (!Validate::notEmpty($body['editMaxUsageAmount'])) {
            $errors[] = ['field' => "editMaxUsageAmount", 'message' => "Maximale gebruiks hoeveelheid mag niet leeg zijn"];
        }

        if (!Validate::notEmpty($body['editType'])) {
            $errors[] = ['field' => "editType", 'message' => "Type mag niet leeg zijn"];
        }

        if (!Validate::notEmpty($body['editActive'])) {
            $errors[] = ['field' => "editActive", 'message' => "Actief mag niet leeg zijn"];
        }

        return $errors;
    }
}
