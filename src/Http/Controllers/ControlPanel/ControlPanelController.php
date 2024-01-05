<?php

namespace Http\Controllers\ControlPanel;

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
        $envHandler = Application::getContainer()->resolve(EnvHandler::class);

        $domain = $envHandler->getEnv('MAIL_SERVER');

        $apiKey = $envHandler->getEnv('MAIL_API_KEY');

        $encryptKey = $envHandler->getEnv('637f45808aa51ac009b842c4a8d714f8');

        $url = "http://" . $domain . "/SendMail";

        $mailTemplate = new MailTemplate(MAIL_TEMPLATES . "ActivateMail.php", ["token" => "123456789"]);

        $data = [
            'to' => 'j.kompier@hotmail.nl', // The email address to send to
            'from' => MailFrom::NOREPLY->value, // The email address to send from
            'body' => $mailTemplate->render(), // The email body
            'key' => openssl_encrypt($apiKey, 'AES-128-ECB', $encryptKey) // The encrypted key
        ];

        $ch = curl_init($url);

        // Set the options for the cURL session
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the cURL session
        $responseFromMail = curl_exec($ch);

        // Close the cURL session
        curl_close($ch);

        dump($responseFromMail);

        $response = new ViewResponse();

        $currentRole = currentRole();

        $response->setBody(view(VIEWS_PATH . 'ControlPanel/ControlPanel.view.php', [
            "currentRole" => $currentRole->toString()
        ])->withLayout(MAIN_LAYOUT));

        return $response;
    }
}
