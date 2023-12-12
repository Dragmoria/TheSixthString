<?php

namespace Http\Controllers\ControlPanel;

use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;

class ManageVouchersController extends Controller
{
    public function show(): ?Response
    {
        $response = new ViewResponse();

        $response->setBody(view(VIEWS_PATH . 'ControlPanel/ManageVouchers.view.php', [])->withLayout(MAIN_LAYOUT));

        return $response;
    }
}
