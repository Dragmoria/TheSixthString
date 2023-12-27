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
use Service\RandomLinkService;
use Service\MailService;
use Service\ActivateService;


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
            'gender' => $user->gender->value,
            'updatedinfo' => !empty($_SESSION["user"]["comment"]) ? $_SESSION["user"]["comment"] : ""
        ])->withLayout(MAIN_LAYOUT));
        $_SESSION["user"]["comment"] ="";

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

        $_SESSION["user"]["comment"] = $postBody['key'];


        $userservice = Application::resolve(UserService::class);
        $updateUser = $userservice->getUserById($user);

        $updateUser->firstName = !empty($postBody['firstname']) ? $postBody['firstname'] : $updateUser->firstName;
        $updateUser->insertion = !empty($postBody['middlename']) ? $postBody['middlename'] : $updateUser->insertion;
        $updateUser->lastName = !empty($postBody['lastname']) ? $postBody['lastname'] : $updateUser->lastName;
        $updateUser->dateOfBirth = !empty($postBody['birthdate']) ? new \DateTime($postBody['birthdate']) : $updateUser->dateOfBirth;
        $updateUser->gender = !empty($postBody['gender']) ? Gender::fromString($postBody['gender']) : $updateUser->gender;
        
        $userservice = Application::resolve(UserService::class);
        $createdUser = $userservice->changePersonalInfo($updateUser);

        $addressService = Application::resolve(AddressService::class);
        $address = $addressService->getAddressByUserId($user, 1);

        $address->street = !empty($postBody['street']) ? $postBody['street'] : $address->street;
        $address->zipCode = !empty($postBody['zipcode']) ? $postBody['zipcode'] : $address->zipCode;
        $address->housenumber = !empty($postBody['housenumber']) ? $postBody['housenumber'] : $address->housenumber;
        $address->housenumberExtension = !empty($postBody['addition']) ? $postBody['addition'] : $address->housenumberExtension;
        $address->city = !empty($postBody['city']) ? $postBody['city'] : $address->city;
        $address->country = !empty($postBody['country']) ? Country::fromString($postBody['country'])->value : $address->country; 
        $address->type = 1;


        $updateAddressService = Application::resolve(AddressService::class);
        $updatedAddress = $updateAddressService->updateAddress($address);
        

    }

    public function updatePasswordAndEmail(): ?Response
    {
        $postBody = $this->currentRequest->getPostObject()->body();
        $user = $_SESSION["user"]["id"];


        if (!isset($postBody['key2'])) {

            $userservice = Application::resolve(UserService::class);
            $updateUser = $userservice->getUserById($user);

            $updateUser->passwordHash = password_hash($postBody['changePassword'], PASSWORD_DEFAULT);
            
            $userservice = Application::resolve(UserService::class);
            $createdUser = $userservice->ChangePasswordUser($updateUser);

        } else{
            
            $userservice = Application::resolve(UserService::class);
            $updateUser = $userservice->getUserById($user);

            $updateUser->passwordHash = password_hash($postBody['changePassword'], PASSWORD_DEFAULT);
            $updateUser->emailAddress = $postBody['email'];
            $updateUser->active = false;
            
            $userservice = Application::resolve(UserService::class);
            $createdUser = $userservice->ChangePasswordAndEmailUser($updateUser);


            $randomLinkService = Application::resolve(RandomLinkService::class);
            $randomLink = $randomLinkService->generateRandomString(32);

            $updateUser->id = $user;
            $updateUser->activationLink = $randomLink;

            $ActivateService = Application::resolve(ActivateService::class);
            $result = $ActivateService->newActivationLink($updateUser);


            $mail = Application::resolve(MailService::class);
            $sender = "noreply@thesixthstring.store";
            $reciever = $updateUser->emailAddress;
            $password = "JarneKompier123!";
            $displayname = "no-reply@thesixthstring.store";
            $subject = "Account activeren";
            $body = $this->ActivateLink($updateUser->firstName, $randomLink);
            $mail->SendMail($sender, $reciever, $password, $displayname, $body, $subject);
        }







    }

    public function ActivateLink($gebruiker, $token)
    {

        $body = "<h1>goedendag </h1> " . $gebruiker .
            "<p>
            Klik op de link om je account te activeren:
            <a href=http://localhost:8080/Activate/" . $token . ">Account activeren</a>
            </p>";
        return $body;

    }
}



















?>