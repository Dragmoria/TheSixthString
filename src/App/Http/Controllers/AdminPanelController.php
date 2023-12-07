<?php

namespace Http\Controllers;

use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\HTTPStatusCodes;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;

class AdminPanelController extends Controller {
    public function show(): ?Response {
        $respone = new ViewResponse();
        
        $respone->setStatusCode(HTTPStatusCodes::OK)
        ->setBody(view(VIEWS_PATH . 'AdminPanel.view.php', [])->withLayout(VIEWS_PATH . 'Layouts/Main.layout.php'))
        ->addHeader('Content-Type', 'text/html');

        return $respone;
    }
}