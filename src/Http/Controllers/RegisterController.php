<?php
namespace Http\Controllers;

use Lib\Enums\Role;
use lib\enums\Gender;
use lib\enums\Country;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\HTTPStatusCodes;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\TextResponse;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Lib\MVCCore\Application;
use Models\AddressModel;
use Models\UserModel;
use Service\UserService;
use Service\AddressService;

class RegisterController extends Controller
{
    public function register(): ?Response
    {
        $Response = new ViewResponse();
        $Response->setBody(view(VIEWS_PATH . 'Register.view.php', [])->withLayout(VIEWS_PATH . 'Layouts/Main.layout.php'));
        return $Response;
    }


    public function saveRegistery(): ?Response
    {

        $postBody = $this->currentRequest->getPostObject()->body();

        $userservice = Application::resolve(UserService::class);
        $user = $userservice->getUserByEmail($postBody['email']);

        if (!isset($user)) {
            

            $newUserModel = new UserModel();

            $newUserModel->emailAddress = $postBody['email'];
            $newUserModel->passwordHash = password_hash($postBody['password'], PASSWORD_DEFAULT);
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

            for ($AddressType = 0; $AddressType <= 1; $AddressType++) {

                $newAddressModel = new AddressModel();

                $newAddressModel->userId = $createdUserId;
                $newAddressModel->street = $postBody['street'];
                $newAddressModel->housenumber = $postBody['housenumber'];
                $newAddressModel->housenumberExtension = $postBody['addition'];
                $newAddressModel->zipCode = $postBody['zipcode'];
                $newAddressModel->city = $postBody['city'];
                $newAddressModel->country = Country::fromString($postBody['country'])->value;
                $newAddressModel->active = true;
                $newAddressModel->type = $AddressType;
                $addressService = Application::resolve(AddressService::class);
                $createdAddress = $addressService->createAddress($newAddressModel);
            }
            return $createdAddress;
        }
        else{
            $Response = new TextResponse();
            $Response->setBody('UserExists');
            return $Response;
        }
    }



}


?>