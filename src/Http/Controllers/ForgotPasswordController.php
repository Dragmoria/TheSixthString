<?php
namespace Http\Controllers;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Lib\MVCCore\Routers\Responses\TextResponse;
use Lib\MVCCore\Application;
use Models\ResetpasswordModel;
use Models\UserModel;
use Service\UserService;
use Service\ResetpasswordService;
use Service\RandomLinkService;


class ForgotPasswordController extends Controller{
    public function ForgotPassword(): ?Response{
        $Response = new ViewResponse();
        $Response->setBody(view(VIEWS_PATH . 'ForgotPassword.view.php', [] )->withLayout(VIEWS_PATH . 'Layouts/Main.layout.php'));
        return $Response;
    }

    public function CreateRandomURL(): ?Response
    {
        $postBody = $this->currentRequest->getPostObject()->body();
        $userservice = Application::resolve(UserService::class);
        $user = $userservice->getUserByEmail($postBody['email']);

        if (!isset($user)){

            $Response = new TextResponse();
            $Response->setBody('NoUserFound');
            return $Response;
        } else{
            $currentDateTime = new \DateTime();

            $randomLinkService = Application::resolve(RandomLinkService::class);
            $randomLink = $randomLinkService->generateRandomString(32);

            $newResetPasswordModel = new ResetpasswordModel();

            $newResetPasswordModel->link = $randomLink;
            $newResetPasswordModel->validUntil = $currentDateTime->modify('+1 hour');
            $newResetPasswordModel->userId = $user->id;

            $resetPasswordService = Application::resolve(ResetpasswordService::class);
            $createdLink = $resetPasswordService->newResetpassword($newResetPasswordModel);
            
        }


    }


}

?>