<?php

namespace Http\Controllers;

use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;

class AdminController extends Controller
{
    public function index(): ?Response
    {
        $secretData = "This is secret data";

        $response = new ViewResponse();

        $response->setBody(view(VIEWS_PATH . 'Admin.view.php', [
            'secretData' => $secretData,
        ])->withLayout(VIEWS_PATH . 'Layouts/Main.layout.php'));

        return $response;
    }
}
