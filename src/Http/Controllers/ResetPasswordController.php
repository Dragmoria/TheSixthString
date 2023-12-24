<?
namespace Http\Controllers;

use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\HTTPStatusCodes;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\TextResponse;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Lib\MVCCore\Application;
use Models\UserModel;
use Service\ResetpasswordService;
use Service\RandomLinkService;
use Service\UserService;




class ResetPasswordController extends Controller
{
    public function ResetPassword($urlData): ?Response
    {
        $Response = new ViewResponse();


        $resetPasswordService = Application::resolve(ResetpasswordService::class);
        $result = $resetPasswordService->getResetpasswordByLink($urlData["dynamicLink"]);

        if (!isset($result)) {
            $Response->setStatusCode(HTTPStatusCodes::NOT_FOUND);
            return $Response;
        } else {
            $userservice = Application::resolve(UserService::class);
            $user = $userservice->getUserById($result[0]->userId);

            $timeString = $result[0]->validUntil->format('Y-m-d H:i:s');
            $currentTime = time();
            $timestamp = strtotime($timeString);

            if ($timestamp < $currentTime) {
                $Response->setBody(view(VIEWS_PATH . 'ResetPassword.view.php', ['error' => "LinkExpired"])->withLayout(VIEWS_PATH . 'Layouts/Main.layout.php'));
                return $Response;
            } else {
                $_SESSION["user"] = [
                    "link" => $urlData["dynamicLink"]
                ];

                $user = $user->firstName;
                $Response->setBody(view(VIEWS_PATH . 'ResetPassword.view.php', ['succes' => $user])->withLayout(VIEWS_PATH . 'Layouts/Main.layout.php'));
                return $Response;
            }
        }
    }


    public function changePasswords(): ?Response
    {   
        $postBody = $this->currentRequest->getPostObject()->body();

        if ($postBody["password"] === $postBody["repeatPassword"]) {

            $resetPasswordService = Application::resolve(ResetpasswordService::class);
            $Resetpassword = $resetPasswordService->getResetpasswordByLink($_SESSION["user"]["link"]);

            $userservice = Application::resolve(UserService::class);
            $user = $userservice->getUserById($Resetpassword[0]->userId);
            if (isset($user)){

                $UpdateUser = new UserModel;

                $UpdateUser->passwordHash = password_hash($postBody['password'], PASSWORD_DEFAULT);
                $UpdateUser->id = $user->id;

                $updatePassword = $userservice->ChangePasswordUser($UpdateUser);
                $deleteLink = $resetPasswordService->deleteResetpasswordByUserId($UpdateUser->id);
                $Response = new TextResponse();
                $Response->setBody('PasswordUpdated');
                return $Response;

            }

        }






    }

}

/*
daar komt dan een array uit

[
    'dynamicLink' => '02340983298490218490'
]

zoiets
*/