<?php
namespace Http\Controllers;

use Lib\Enums\Role;
use lib\enums\Gender;
use lib\enums\Country;
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

            for ($AddressType = 1; $AddressType <= 2; $AddressType++) {
            $newAddressModel = new AddressModel();
            
            $newAddressModel->userId = $createdUserId;
            $newAddressModel->street = $postBody['street'];
            $newAddressModel->housenumber = $postBody['housenumber'];
            $newAddressModel->housenumberExtension = $postBody['addition'];
            $newAddressModel->zipCode = $postBody['zipcode'];
            $newAddressModel->city = $postBody['city'];
            $newAddressModel->country = Country::fromString($postBody['country']);
            $newAddressModel->active = true;
            $newAddressModel->type = $AddressType;

            dumpDie($createdUserId);
            }
    }



}


?>