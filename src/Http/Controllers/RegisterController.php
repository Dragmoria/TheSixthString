<?php
namespace Http\Controllers;

use Lib\Enums\Role;
use lib\enums\Gender;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Lib\MVCCore\Application;
use Models\AddressModel;
use Models\UserModel;
use Service\UserService;

class RegisterController extends Controller
{
    public function register(): ?Response
    {
        $Response = new ViewResponse();
        $Response->setBody(view(VIEWS_PATH . 'Register.view.php', [])->withLayout(VIEWS_PATH . 'Layouts/Main.layout.php'));
        return $Response;
    }

    public function get(): ?Response
    {
        $request = $this->currentRequest;
        if ($request->hasPostObject()) {
            //dumpDie($request->getPostObject()->body());
        }
    }




    public function saveRegistery() :?Response
    {
       
        $postBody = $this->currentRequest->getPostObject()->body();


        $newUserModel = new UserModel();

        $newUserModel->emailAddress = $postBody['email'];
        $newUserModel->passwordHash = password_hash($postBody['password'],PASSWORD_DEFAULT);
        $newUserModel->role = Role::Customer;
        $newUserModel->firstName = $postBody['firstname'];
        $newUserModel->insertion = $postBody['middlename'];
        $newUserModel->lastName = $postBody['lastname'];
        $newUserModel->dateOfBirth = new \DateTime($postBody['birthdate']);
        $newUserModel->gender = Gender::fromString($postBody['gender']);
        $newUserModel->active = true;
        $newUserModel->createdOn = new \DateTime('now');
        $userservice = Application::resolve(UserService::class);
        $createdUser = $userservice->createCustomer($newUserModel);
        $createdUserId = $createdUser->id;
        dumpDie($createdUserId);
        
    }



}


?>