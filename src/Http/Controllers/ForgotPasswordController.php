<?php
namespace Http\Controllers;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;

class ForgotPasswordController extends Controller{
    public function ForgotPassword(): ?Response{
        $Response = new ViewResponse();
        $Response->setBody(view(VIEWS_PATH . 'ForgotPassword.view.php', [] )->withLayout(VIEWS_PATH . 'Layouts/Main.layout.php'));
        return $Response;
    }
}

?>