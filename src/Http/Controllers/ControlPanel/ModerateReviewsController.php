<?php

namespace Http\Controllers\ControlPanel;

use Lib\Enums\ReviewStatus;
use Lib\Enums\SortOrder;
use Lib\MVCCore\Application;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\JsonResponse;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Models\ReviewModel;
use Service\ReviewService;

class ModerateReviewsController extends Controller
{
    public function show(): ?Response
    {
        $response = new ViewResponse();

        $response->setBody(view(VIEWS_PATH . 'ControlPanel/ModerateReviews.view.php', [])->withLayout(CONTROLPANEL_LAYOUT));

        return $response;
    }

    public function getReviewsTableData(): ?Response
    {
        $params = $this->currentRequest->urlQueryParams();
        $offset = $params['offset'];
        $limit = $params['limit'];
        $sort = $params['sort'];
        $order = SortOrder::from($params['order'] == "" ? "asc" : $params['order']);

        $reviewService = Application::resolve(ReviewService::class);

        $reviews = $reviewService->getAllReviews($sort, $order);

        if ($reviews === null) {
            $response = new JsonResponse();
            $response->setBody([
                "total" => 0,
                "rows" => []
            ]);
            return $response;
        }

        $reviewsJson = [];
        foreach ($reviews as $review) {
            $reviewJson = (array) $review;
            $reviewJson['createdOn'] = $review->createdOn;
            $reviewJson['status'] = $review->status->toString();

            $reviewsJson[] = $reviewJson;
        }

        $reviewsJson = array_slice($reviewsJson, $offset, $limit);

        $response = new JsonResponse();

        $response->setBody([
            "total" => count($reviews),
            "rows" => $reviewsJson
        ]);

        return $response;
    }

    public function setReviewStatus(): ?Response
    {
        $postBody = $this->currentRequest->postObject->body();
        $reviewId = (int) $postBody['id'];
        $approve = $postBody['approve'] == "true";

        $reviewService = Application::resolve(ReviewService::class);

        if ($approve) {
            $reviewService->acceptReview($reviewId);
        } else {
            $reviewService->denyReview($reviewId);
        }

        $response = new JsonResponse();

        $response->setBody([
            "success" => true
        ]);

        return $response;
    }
}
