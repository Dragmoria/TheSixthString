<?php
namespace Http\Controllers;

use EmailTemplates\Mail;
use EmailTemplates\MailFrom;
use EmailTemplates\MailTemplate;
use Lib\Enums\Role;
use lib\enums\Gender;
use lib\enums\Country;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\JsonResponse;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\TextResponse;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Lib\MVCCore\Application;
use Models\UserModel;
use Service\AddressService;
use Service\OrderItemService;
use Service\OrderService;
use Service\ProductService;
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
        $user = $userservice->getUserById($_SESSION["user"]["id"]);         // getting the user model based on the logged in user. this because we want to fill all the input fields of the "change info" page with current info about this user

        if (!isset($user)) {
            redirect("/Login");
        }

        $addressService = Application::resolve(AddressService::class);
        $address = $addressService->getAddressByUserId($user->id, 1);       // getting the address model based on the logged in user. this because we want to fill all the input fields of the "change info" page with current info about this user

        $Response->setBody(view(VIEWS_PATH . 'AccountPage.view.php', [
            'firstname' => $user->firstName,
            'addition' => $user->insertion,
            'lastname' => $user->lastName,
            'email' => $user->emailAddress,                                 // all these details are used to fill the forms with the data that is currently in the database of this user
            'street' => $address->street ?? "",
            'housenumber' => $address->housenumber ?? "",
            'housenumberextension' => $address->housenumberExtension ?? "",
            'zipcode' => $address->zipCode ?? "",
            'city' => $address->city ?? "",
            'klantnummer' => $user->id,
            'country' => $address->country ?? "",
            'birthdate' => $user->dateOfBirth->format('Y-m-d'),
            'gender' => $user->gender->value,
        ])->withLayout(MAIN_LAYOUT));
        return $Response;
    }

    public function Logout(): ?Response
    {
        unset($_SESSION['user']);                                           // loggin out the users and forcing them to the inlog page so they cannot go to pages they shouldnt
        redirect('/Login');
    }

    public function updateInfo(): ?Response
    {
        $postBody = $this->currentRequest->getPostObject()->body();         // getting all the data from the form that was serialized by the Ajax request in the AccountPage View.
        $user = $_SESSION["user"]["id"];                                    // getting the user from the Session details

        $userservice = Application::resolve(UserService::class);
        $updateUser = $userservice->getUserById($user);                     // getting the correct user based on the ID from the database and return it as a model.

        $updateUser->firstName = !empty($postBody['firstname']) ? $postBody['firstname'] : $updateUser->firstName;                          //changing all the information the user has entered.
        $updateUser->insertion = !empty($postBody['middlename']) ? $postBody['middlename'] : $updateUser->insertion;                        //any field that is left empty will be reassigned its own value.
        $updateUser->lastName = !empty($postBody['lastname']) ? $postBody['lastname'] : $updateUser->lastName;
        $updateUser->dateOfBirth = !empty($postBody['birthdate']) ? new \DateTime($postBody['birthdate']) : $updateUser->dateOfBirth;
        $updateUser->gender = !empty($postBody['gender']) ? Gender::fromString($postBody['gender']) : $updateUser->gender;

        $userservice = Application::resolve(UserService::class);
        $createdUser = $userservice->changePersonalInfo($updateUser);       // entering all the details, that are supposed to go into the `user` table, into the database.

        $addressService = Application::resolve(AddressService::class);
        $address = $addressService->getAddressByUserId($user, 1);

        $address->street = !empty($postBody['street']) ? $postBody['street'] : $address->street;                            //changing all the information the user has entered.
        $address->zipCode = !empty($postBody['zipcode']) ? $postBody['zipcode'] : $address->zipCode;                        //any field that is left empty will be reassigned its own value.
        $address->housenumber = !empty($postBody['housenumber']) ? $postBody['housenumber'] : $address->housenumber;
        $address->housenumberExtension = !empty($postBody['addition']) ? $postBody['addition'] : $address->housenumberExtension;
        $address->city = !empty($postBody['city']) ? $postBody['city'] : $address->city;
        $address->country = !empty($postBody['country']) ? Country::fromString($postBody['country'])->value : $address->country;
        $address->type = 1;

        $updateAddressService = Application::resolve(AddressService::class);
        $updatedAddress = $updateAddressService->updateAddress($address);
    }

    public function updateUserPassword(): ?Response
    {
        $postBody = $this->currentRequest->getPostObject()->body();
        $user = $_SESSION["user"]["id"];

        $userservice = Application::resolve(UserService::class);
        $updateUser = $userservice->getUserById($user);

        $updateUser->passwordHash = password_hash($postBody['changePassword'], PASSWORD_DEFAULT);

        $userservice = Application::resolve(UserService::class);
        $createdUser = $userservice->ChangePasswordUser($updateUser);

        $Response = new TextResponse();
        $Response->setBody('PasswordUpdated');
        return $Response;
    }

    public function updateEmail(): ?Response
    {
        $postBody = $this->currentRequest->getPostObject()->body();
        $user = $_SESSION["user"]["id"];

        $userservice = Application::resolve(UserService::class);
        $updateUser = $userservice->getUserById($user);

        $updateUser->emailAddress = $postBody['email'];
        $updateUser->active = false;

        $userservice = Application::resolve(UserService::class);
        $createdUser = $userservice->ChangeEmail($updateUser);

        $randomLinkService = Application::resolve(RandomLinkService::class);
        $randomLink = $randomLinkService->generateRandomString(32);

        $updateUser->id = $user;
        $updateUser->activationLink = $randomLink;

        $ActivateService = Application::resolve(ActivateService::class);
        $result = $ActivateService->newActivationLink($updateUser);

        $mailtemplate = new MailTemplate(MAIL_TEMPLATES . 'ActivateMail.php', [
            'gebruiker' => $createdUser->firstName,
            'token' => $randomLink
        ]);

        $mail = new Mail($postBody['email'], "Account activeren", $mailtemplate, MailFrom::NOREPLY, "no-reply@thesixthstring.store");
        $mail->send();
        return $result;
    }

    public function deleteAccount(): ?Response
    {
        $user = $_SESSION["user"]["id"];
        $userservice = Application::resolve(UserService::class);

        $userToDelete = $userservice->deleteUser($user);
        unset($_SESSION["user"]);

        return $userToDelete;

    }

    public function DeleteFinished(): ?Response
    {
        $Response = new ViewResponse();
        $Response->setBody(view(VIEWS_PATH . 'AccountDeleted.view.php', [])->withLayout(MAIN_LAYOUT));
        return $Response;

    }

    public function RetrievingOrderHistory(): ?JsonResponse
    {
        $userId = $_SESSION["user"]["id"];
        $orderService = Application::resolve(OrderService::class);
        $orders = $orderService->getOrdersById($userId);
        $addressService = Application::resolve(AddressService::class);
        $shippingInfo = [];

        foreach ($orders as $orderModel) {
            // Access the shippingAddressId property directly
            $shippingInfo[$orderModel->id . " shippingAddress"] = $addressService->getAddressById($orderModel->shippingAddressId);
            $shippingInfo[$orderModel->id . " invoiceAddress"] = $addressService->getAddressById($orderModel->invoiceAddressId);
        }
        $response = ["orders" => $orders, "Addresses" => $shippingInfo];
        $JsonResponse = new JsonResponse();
        $JsonResponse->setBody($response);
        return $JsonResponse;
    }


    public function GetOrderOverview(): ?Response
    {
        $postBody = $this->currentRequest->getPostObject()->body();

        $productservice = Application::resolve(ProductService::class);
        $products = $productservice->getProductsByOrderId($postBody['Order']);
        $orderItemservice = Application::resolve(OrderItemService::class);
        $orderItems = $orderItemservice->getOrderItemByOrderId($postBody['Order']);

        $response = ["orderId" => $postBody['Order'], "Products" => $products,"orderItems" => $orderItems];
        $JsonResponse = new JsonResponse();
        $JsonResponse->setBody($response);
        return $JsonResponse;
    }

    public function LogOutPulse()
    {
        unset($_SESSION['user']);
        echo 'LOGGED_OUT';
        exit;

    }



}



















?>