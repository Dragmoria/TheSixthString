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
use Service\UserService;
use Service\AddressService;

class MailController extends Controller
{
    public function mail(): ?Response
    {
        $Response = new ViewResponse();
        $Response->setBody(view(VIEWS_PATH . 'Mail.view.php', [])->withLayout(VIEWS_PATH . 'Layouts/Main.layout.php'));
        // $test->test();

        $mailTemplate = new MailTemplate(MAIL_TEMPLATES . 'ResetPasswordTemplate.php', ["token" => "14984938948302948023984"]);


        $mail = new Mail('j.kompier@hotmail.nl', 'Test mail', $mailTemplate, MailFrom::NOREPLY, "noreply sixth string");
        $mail->send();


        return $Response;
    }


    public function sendEmail(): ?Response
    {
    }
}
