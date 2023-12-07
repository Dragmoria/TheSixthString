<?php

namespace Http\Controllers;

use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;

class HomeController extends Controller {
    public function index(): ?Response {
        $response = new ViewResponse();
        $response->setBody(view(VIEWS_PATH . 'index.view.php', ['name' => 'Jeroen']));
        return $response;
    }
}