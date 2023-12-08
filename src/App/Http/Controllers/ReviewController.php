<?php

namespace Http\Controllers;

//use Http\Middlewares\Roles;

use Lib\MVCCore\Application;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\HTTPStatusCodes;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Lib\Service\ReviewService;

class ReviewController extends Controller {
    public function index(): void {
        $review = Application::resolve(ReviewService::class)->getReviewTest();

        $response = new ViewResponse();

        $response->setStatusCode(HTTPStatusCodes::OK)
            ->setBody(view(VIEWS_PATH . 'Review.view.php', ['review' => $review])
            //    ->withLayout(VIEWS_PATH . 'Layouts/Main.layout.php')
            )
            ->addHeader('Content-Type', 'text/html');

//        $_SESSION["user"] = ['role' => Roles::Admin->value];

        $this->setResponse($response);
    }
}