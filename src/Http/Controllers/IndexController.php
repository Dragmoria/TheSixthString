<?php

namespace Http\Controllers;

use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Lib\MVCCore\Application;
use Service\BaseDatabaseService;
use Service\ProductService;

class IndexController extends Controller
{
    public function show(): ?Response
    {
        $response = new ViewResponse();

        $products = Application::resolve(ProductService::class)->getProductsFrontpage();

        $response->setBody(
            view(
                VIEWS_PATH . 'Index.view.php',
                [
                    'products' => $products,
                ]
            )->withLayout(MAIN_LAYOUT)
        );

        return $response;
    }
}