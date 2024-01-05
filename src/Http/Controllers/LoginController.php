<?php
namespace Http\Controllers;


use Lib\MVCCore\Application;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Lib\MVCCore\Routers\HTTPStatusCodes;
use Service\ShoppingCartService;
use Service\UserService;

class LoginController extends Controller
{
    public function loginPage(): ?Response
    {

        $postObject = $this->currentRequest->getPostObject();
        $oldValueEmail = $postObject->oldBody()['email'] ?? null;
        $oldValuePassword = $postObject->oldBody()['password'] ?? null;
        $error = $postObject->getPostError('error') ?? null;

        $Response = new ViewResponse();

        $Response->setStatusCode(HTTPStatusCodes::OK)
            ->setBody(view(VIEWS_PATH . 'loginPage.view.php', [
                'oldValueEmail' => $oldValueEmail,
                'oldValuePassword' => $oldValuePassword,
                'error' => $error
            ])->withLayout(MAIN_LAYOUT));

        $postObject->flush();
        unset($_SESSION['error']);
        return $Response;
    }

    public function validateLogin(): ?Response
    {
        unset($_SESSION['error'], $_SESSION['success']);
        $postObject = $this->currentRequest->getPostObject();
        $postBody = $postObject->body();

        $userservice = Application::resolve(UserService::class);
        $user = $userservice->getUserByEmail($postBody['email']);


        if (isset($user)) {
            if ($user->active === true) {
                if (password_verify($postBody["password"], $user->passwordHash)) {
                    $_SESSION["user"] = [
                        "id" => $user->id,
                        "role" => $user->role,
                        "firstname" => $user->firstName
                    ];

                    Application::resolve(ShoppingCartService::class)->mergeCarts($user->id, $_SESSION["sessionUserGuid"]);

                    redirect("/Account");
                } else {
                    $errorCheck = true;
                }
            } else {
                $errorCheck = true;
            }
        } else {
            $errorCheck = true;
        }


        if ($errorCheck === true) {
            $postObject->flash();
            $postObject->flashPostError('error', "block");
            redirect("/Login");
        }
    }

}


?>