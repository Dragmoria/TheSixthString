<?php

namespace Http\Controllers\ControlPanel;

use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\JsonResponse;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;

class ManageCouponsController extends Controller
{
    public function show(): ?Response
    {
        $response = new ViewResponse();

        $response->setBody(view(VIEWS_PATH . 'ControlPanel/ManageCoupons.view.php', [])->withLayout(CONTROLPANEL_LAYOUT));

        return $response;
    }

    public function getVouchers(): ?Response
    {
        $response = new JsonResponse();

        $response->setBody(["hi" => "hi"]);




        return $response;
    }
}
