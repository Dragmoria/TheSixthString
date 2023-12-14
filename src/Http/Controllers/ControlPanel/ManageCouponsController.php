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

    public function getCoupons(): ?Response
    {
        $params = $this->currentRequest->urlQueryParams();
        $search = $params['search'];
        $offset = $params['offset'];
        $limit = $params['limit'];
        $sort = $params['sort'];
        $order = SortOrder::from($params['order'] == "" ? "asc" : $params['order']);

        $couponService = Application::resolve(CouponService::class);

        $coupons = $couponService->getCoupons($sort, $order);


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

        $toUpdateCoupon = $couponService->getCouponById((int)$postBody['id']);

        $toUpdateCoupon->name = $postBody['name'];
        $toUpdateCoupon->code = $postBody['code'];
        $toUpdateCoupon->value = $postBody['value'];
        $toUpdateCoupon->endDate = $postBody['endDate'] === null ? null : new \DateTime($postBody['endDate']);
        $toUpdateCoupon->maxUsageAmount = $postBody['maxUsageAmount'];
        $toUpdateCoupon->active = $postBody['active'] == "true" ? true : false;
        $toUpdateCoupon->type = CouponType::fromString($postBody['type']);

        $succes = $couponService->updateCoupon($toUpdateCoupon);

        $response = new TextResponse();

        $response->setBody("Coupon updated");
        return $response;
    }

    private function validateNewCoupon(array $body): array
    {
    }

    private function validateUpdateCoupon(array $body): array
    {
        $errors = [];

        if (!Validate::notEmpty($body['id'])) {
            $errors['id'] = "Id mag niet leeg zijn";
        }

        if (!Validate::isNumber($body['id'])) {
            $errors['id'] = "Id moet een getal zijn";
        }

        if (!Validate::notEmpty($body['name'])) {
            $errors['name'] = "Naam mag niet leeg zijn";
        }

        if (!Validate::notEmpty($body['code'])) {
            $errors['code'] = "Code mag niet leeg zijn";
        }

        if (!Validate::notEmpty($body['value'])) {
            $errors['value'] = "Waarde mag niet leeg zijn";
        }

        if (!Validate::isNumber($body['value'])) {
            $errors['value'] = "Waarde moet een getal zijn";
        }

        if (!Validate::dateString($body['endDate'])) {
            $errors['endDate'] = "Eind datum is niet in geldig formaat";
        }

        if (!Validate::notEmpty($body['endDate'])) {
            $errors['endDate'] = "Eind datum mag niet leeg zijn";
        }

        if (!Validate::notEmpty($body['maxUsageAmount'])) {
            $errors['maxUsageAmount'] = "Maximale gebruiks hoeveelheid mag niet leeg zijn";
        }

        if (!Validate::notEmpty($body['type'])) {
            $errors['type'] = "Type mag niet leeg zijn";
        }

        if (!Validate::notEmpty($body['active'])) {
            $errors['active'] = "Actief mag niet leeg zijn";
        }

        return $errors;
    }
}
