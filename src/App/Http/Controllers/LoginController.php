<?php

namespace Http\Controllers;

use Http\Middlewares\Roles;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\HTTPStatusCodes;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;

class LoginController extends Controller {
    public function show(): ?Response {
        $respone = new ViewResponse();

        $respone->setStatusCode(HTTPStatusCodes::OK)
        ->setBody(view(VIEWS_PATH . 'Login.view.php', [])
        ->withLayout(VIEWS_PATH . 'Layouts/Main.layout.php'))
        ->addHeader('Content-Type', 'text/html');

        $_SESSION["user"] = ['role' => Roles::Admin->value];

        return $respone;
    }

    public function logout(): void {
        unset($_SESSION["user"]);
        redirect('/');
    }
}