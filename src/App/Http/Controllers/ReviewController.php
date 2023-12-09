<?php

namespace Http\Controllers;

//use Http\Middlewares\Roles;

use Lib\MVCCore\Application;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\HTTPStatusCodes;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Service\ReviewService;

class ReviewController extends Controller {
    public function index(): void {
        $reviews = Application::resolve(ReviewService::class)->getAllReviewsForProduct(1);

        $response = new ViewResponse();
        $response->setStatusCode(HTTPStatusCodes::OK)
            ->setBody(view(VIEWS_PATH . 'Review.view.php', ['reviews' => $reviews]))
            ->addHeader('Content-Type', 'text/html');

        $this->setResponse($response);
    }
}