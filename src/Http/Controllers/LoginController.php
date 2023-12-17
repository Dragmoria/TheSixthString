<?php
namespace Http\Controllers;


use Lib\MVCCore\Application;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Lib\MVCCore\Routers\HTTPStatusCodes;
use Service\UserService;

class LoginController extends Controller
{
    public function loginPage(): ?Response
    {

        $postObject = $this->currentRequest->getPostObject();
        $oldValueEmail = $postObject->oldBody()['email'] ?? null;
        $oldValuePassword = $postObject->oldBody()['password'] ?? null;


        $Response = new ViewResponse();
        $Response->setStatusCode(HTTPStatusCodes::OK)

        ->setBody(view(VIEWS_PATH . 'loginPage.view.php', [
            'oldValueEmail' => $oldValueEmail,
            'oldValuePassword' => $oldValuePassword,
            'error' => $postObject->getPostError('textfield'),
            'success' => $postObject->getPostSuccess('textfield')
        ])->withLayout(VIEWS_PATH . 'Layouts/Main.layout.php'))
        ->addHeader('Content-Type', 'text/html');

        $postObject->flush();
        unset($_SESSION['error'], $_SESSION['success']);
        return $Response;
    }
}