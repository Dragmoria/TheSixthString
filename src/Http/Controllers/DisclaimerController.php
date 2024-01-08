<?php

namespace Http\Controllers;

use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;

class DisclaimerController extends Controller
{
    public function show(): ?Response
    {
        $response = new ViewResponse();
        $response->setBody(view(VIEWS_PATH . 'Disclaimer.view.php', [

        ])->withLayout(MAIN_LAYOUT));
        return $response;
    }
}