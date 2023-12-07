<?php

namespace Http\Controllers;

use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;

class ProductsController extends Controller {
    public function show(): ?Response {
        $response = new ViewResponse();

        $response->setBody(view(VIEWS_PATH . 'Products.view.php', [
            'goedendag' => "Hallo daar."
        ])->withLayout(VIEWS_PATH . 'Layouts/Main.layout.php'));

        return $response;
    }
}