<?php
namespace Http\Controllers;

use EmailTemplates\Mail;
use EmailTemplates\MailFrom;
use EmailTemplates\MailTemplate;
use Lib\Enums\Role;
use lib\Enums\Gender;
use lib\Enums\Country;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\HTTPStatusCodes;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\TextResponse;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Lib\MVCCore\Application;
use Models\AddressModel;
use Models\UserModel;
use Service\ActivateService;
use Service\UserService;
use Service\AddressService;
use Service\RandomLinkService;
use Service\MailService;

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
        if ($postBody["password"] === $postBody["repeatPassword"]) {

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
                $newUserModel->active = false;
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


                $randomLinkService = Application::resolve(RandomLinkService::class);
                $randomLink = $randomLinkService->generateRandomString(32);

                $newUserModel->id = $createdUserId;
                $newUserModel->activationLink = $randomLink;


                $ActivateService = Application::resolve(ActivateService::class);
                $result = $ActivateService->newActivationLink($newUserModel);

                $mailtemplate = new MailTemplate(MAIL_TEMPLATES . 'ActivateMail.php', [
                    'gebruiker' => $createdUser->firstName,
                    'token' => $randomLink
                ]);
    
                $mail = new Mail($newUserModel->emailAddress,"Account activeren", $mailtemplate, MailFrom::NOREPLY, "no-reply@thesixthstring.store");
                $mail->send();
                return $result;
            } else {
                $Response = new TextResponse();
                $Response->setBody('UserExists');
                return $Response;
            }
        } else {
            $Response = new TextResponse();
            $Response->setBody('PasswordNotMatching');
            return $Response;
        }

    }



    public function Activate($urlData): ?Response
    {
        $Response = new ViewResponse();
        $ActivateService = Application::resolve(ActivateService::class);
        $userModel = $ActivateService->getUserByLink($urlData["dynamiclink"]);

        $userModel->active = true;

        $result = $ActivateService->changeActiveStatus($userModel);

        if (!isset($result)) {
            $Response->setStatusCode(HTTPStatusCodes::NOT_FOUND);
            return $Response;
        } else {

            $Response->setBody(view(VIEWS_PATH . 'AccountActivated.view.php', [])->withLayout(VIEWS_PATH . 'Layouts/Main.layout.php'));
            return $Response;


        }
    }



 





}


?>