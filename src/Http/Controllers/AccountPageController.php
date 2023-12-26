<?php
namespace Http\Controllers;

use Lib\Enums\Role;
use lib\enums\Gender;
use lib\enums\Country;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Lib\MVCCore\Application;
use Models\UserModel;
use Service\AddressService;
use Service\UserService;
use Models\AddressModel;




class AccountPageController extends Controller
{
    public function AccountPage(): ?Response
    {

        $Response = new ViewResponse();

        $userservice = Application::resolve(UserService::class);
        $user = $userservice->getUserById($_SESSION["user"]["id"]);
        $addressService = Application::resolve(AddressService::class);
        $address = $addressService->getAddressByUserId($user->id, 1);

        $Response->setBody(view(VIEWS_PATH . 'AccountPage.view.php', [
            'firstname' => $user->firstName,
            'addition' => $user->insertion,
            'lastname' => $user->lastName,
            'email' => $user->emailAddress,
            'street' => $address->street,
            'housenumber' =>$address->housenumber,
            'housenumberextension' => $address->housenumberExtension,
            'zipcode' => $address->zipCode,
            'city' => $address->city,
            'klantnummer' => $user->id,
            'country' => $address->country,
            'birthdate' => $user->dateOfBirth->format('Y-m-d'),
            'gender' => $user->gender->value
        ])->withLayout(MAIN_LAYOUT));

        return $Response;
            
    }

    public function Logout(): ?Response
    {
        unset($_SESSION['user']);
        redirect('/Login');
        
    }


    public function updateInfo(): ?Response
    {
        $postBody = $this->currentRequest->getPostObject()->body();
        $user = $_SESSION["user"]["id"];
        
        $userservice = Application::resolve(UserService::class);
        $updateUser = $userservice->getUserById($user);

        $updateUser->emailAddress = !empty($postBody['email']) ? $postBody['email'] : $updateUser->emailAddress;
        $updateUser->firstName = !empty($postBody['firstname']) ? $postBody['firstname'] : $updateUser->firstName;
        $updateUser->insertion = !empty($postBody['middlename']) ? $postBody['middlename'] : $updateUser->insertion;
        $updateUser->lastName = !empty($postBody['lastname']) ? $postBody['lastname'] : $updateUser->lastName;
        $updateUser->dateOfBirth = !empty($postBody['birthdate']) ? new \DateTime($postBody['birthdate']) : $updateUser->dateOfBirth;
        $updateUser->gender = !empty($postBody['gender']) ? Gender::fromString($postBody['gender']) : $updateUser->gender;

        $userservice = Application::resolve(UserService::class);
        $createdUser = $userservice->changePersonalInfo($updateUser);

    }


}



















?>