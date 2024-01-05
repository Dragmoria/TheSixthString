<?php

namespace Http\Controllers\ControlPanel;

use EmailTemplates\Mail;
use EmailTemplates\MailFrom;
use EmailTemplates\MailTemplate;
use Lib\Enums\Role;
use Lib\EnvUtility\EnvHandler;
use Lib\MVCCore\Application;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;

class ControlPanelController extends Controller
{
    public function show(): ?Response
    {
        $response = new ViewResponse();

        $currentRole = currentRole();

        $response->setBody(view(VIEWS_PATH . 'ControlPanel/ControlPanel.view.php', [
            "currentRole" => $currentRole->toString()
        ])->withLayout(MAIN_LAYOUT));

        return $response;
    }

    public function testMail(): ?Response
    {
        $mailTemplate = new MailTemplate(MAIL_TEMPLATES . "ActivateMail.php", ["token" => "123456789"]);

        $mail = new Mail("j.kompier@hotmail.nl", "Test subject", $mailTemplate, MailFrom::NOREPLY, "Mailer name");
        $result = $mail->send();

        dump($result);

        $response = new ViewResponse();

        $response->setBody(view(VIEWS_PATH . 'ControlPanel/ControlPanel.view.php', [
            "currentRole" => "piet"
        ])->withLayout(MAIN_LAYOUT));

        return $response;
    }
}
