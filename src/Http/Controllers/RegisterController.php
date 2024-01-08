<?php
namespace Http\Controllers;

use EmailTemplates\Mail;
use EmailTemplates\MailFrom;
use EmailTemplates\MailTemplate;
use Lib\Enums\Role;
use Lib\Enums\Gender;
use Lib\Enums\Country;
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
                $ActivateService->newActivationLink($newUserModel);

                $mailtemplate = new MailTemplate(MAIL_TEMPLATES . 'ActivateMail.php', [
                    'gebruiker' => $createdUser->firstName,
                    'token' => $randomLink
                ]);

                $mail = new Mail($newUserModel->emailAddress, "Account activeren", $mailtemplate, MailFrom::NOREPLY, "no-reply@thesixthstring.store");
                $mail->send();
                $Response = new TextResponse();
                $Response->setBody('UserCreated');
                return $Response;
            } else {
                $Response = new TextResponse();
                $Response->setStatusCode(HTTPStatusCodes::CONFLICT);
                $Response->setBody('UserExists');
                return $Response;
            }
        } else {
            $Response = new TextResponse();
            $Response->setStatusCode(HTTPStatusCodes::BAD_REQUEST);
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