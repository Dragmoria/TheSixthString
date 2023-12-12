<?php

namespace Http\Controllers\ControlPanel;

use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;

class StatisticsController extends Controller
{
    public function show(): ?Response
    {
        $response = new ViewResponse();

        $response->setBody(view(VIEWS_PATH . 'ControlPanel/Statistics.view.php', [])->withLayout(MAIN_LAYOUT));

        return $response;
    }
}