<?php

namespace Http\Controllers;

use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;

class OverigController extends Controller {
    public function show(): ?Response {
        $response = new ViewResponse();
        $response->setBody(view(VIEWS_PATH . 'Overig.view.php', [
            
        ])->withLayout(MAIN_LAYOUT));
        return $response;
    }
}