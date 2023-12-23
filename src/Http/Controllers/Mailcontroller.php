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
use Service\MailService;

class MailController extends Controller
{
    public function mail(): ?Response
    {
        $Response = new ViewResponse();
        $Response->setBody(view(VIEWS_PATH . 'Mail.view.php', [])->withLayout(VIEWS_PATH . 'Layouts/Main.layout.php'));
        $test = Application::resolve(MailService::class);
        $test->test();

        return $Response;
    }


    public function sendEmail(): ?Response{



    }
}


