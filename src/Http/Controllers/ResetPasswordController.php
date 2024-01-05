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
use Service\UserService;



class ResetPasswordController extends Controller
{
    public function ResetPassword($urlData): ?Response
    {
        $Response = new ViewResponse();

        $resetPasswordService = Application::resolve(ResetpasswordService::class);
        $result = $resetPasswordService->getResetpasswordByLink($urlData["dynamiclink"]);

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

            $password = $postBody["password"];
            $regexLength = '/.{6,}/';
            $regexCapital = '/[A-Z]/';
            $regexRegular = '/[a-z]/';
            $regexNumber = '/[0-9]/';

            if (!preg_match($regexLength, $password) || !preg_match($regexCapital, $password) || !preg_match($regexRegular, $password) || !preg_match($regexNumber, $password)) {
                $Response = new TextResponse();
                $Response->setStatusCode(HTTPStatusCodes::NOT_ACCEPTABLE);
                $Response->setBody('PasswordIncorrectFormat');
                return $Response;
            }


            $resetPasswordService = Application::resolve(ResetpasswordService::class);
            $Resetpassword = $resetPasswordService->getResetpasswordByLink($_SESSION["user"]["link"]);

            $userservice = Application::resolve(UserService::class);
            $user = $userservice->getUserById($Resetpassword[0]->userId);
            if (isset($user)){

                $UpdateUser = new UserModel;

                $UpdateUser->passwordHash = password_hash($postBody['password'], PASSWORD_DEFAULT);
                $UpdateUser->id = $user->id;

                $userservice->ChangePasswordUser($UpdateUser);
                $resetPasswordService->deleteResetpasswordByUserId($UpdateUser->id);
                $Response = new TextResponse();
                $Response->setBody('PasswordUpdated');
                return $Response;

            }

        }

    }

}
