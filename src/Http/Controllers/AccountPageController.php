<?php
namespace Http\Controllers;

use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Lib\MVCCore\Application;
use Service\AddressService;
use Service\UserService;



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
            'klantnummer' => $user->id
        ])->withLayout(MAIN_LAYOUT));
        
        return $Response;

    }

    public function Logout(): ?Response
    {
        unset($_SESSION['user']);
        redirect('/Login');
        
    }


}



















?>