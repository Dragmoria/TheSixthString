<?php
namespace Http\Controllers;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;

class LoginController extends Controller{
    public function loginPage(): ?Response{
        $Response = new ViewResponse();
        $Response->setBody(view(VIEWS_PATH . 'loginPage.view.php', [] )->withLayout(VIEWS_PATH . 'Layouts/Main.layout.php'));
        return $Response;
    }
}