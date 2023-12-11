<?php

namespace Http\Controllers\ControlPanel;

use Lib\Enums\Role;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;

class ControlPanelController extends Controller
{
    public function show(): ?Response
    {
        $response = new ViewResponse();

        $currentRole = currentRole();

        $response->setBody(view(VIEWS_PATH . 'ControlPanel/ControlPanel.view.php', [
            "currentRole" => $currentRole->toString()
        ])->withLayout(MAIN_LAYOUT));

        return $response;
    }
}
