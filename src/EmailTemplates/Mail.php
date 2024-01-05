<?php

namespace EmailTemplates;

use Lib\EnvUtility\EnvHandler;
use Lib\MVCCore\Application;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Mail
{
    public string $to;

    public string $subject;

    public string $body;

    public readonly MailFrom $from;

    public readonly string $password;

    public readonly string $name;

    public ?string $altBody;

    private EnvHandler $envHandler;

    public function __construct(string $to, string $subject, MailTemplate $body, MailFrom $from, string $mailerName, ?MailTemplate $altBody = null)
    {
        $this->envHandler = Application::resolve(EnvHandler::class);

        $this->to = $to;
        $this->subject = $subject;
        $this->body = $body->render();
        $this->altBody = $altBody?->render();
        $this->from = $from;

        $env = Application::resolve(EnvHandler::class);

        $this->password = $env->getEnv('MAIL_PASSWORD_' . $this->from->getName());

        $this->name = $mailerName;
    }

    private function sendWithoutApi(): bool
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug  = 2;                   //Send using SMTP
        $mail->Host       = 'smtp-mail.outlook.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $this->from->value;                     //SMTP username
        $mail->Password   = $this->password;                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`                                 //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Mail versturen settings
        $mail->setFrom($mail->Username, $this->name);
        $mail->addAddress($this->to);     //Add a recipient
        $mail->addReplyTo('info@thesixthstring.store', 'Information');


        $mail->isHTML(true);
        $mail->Subject = $this->subject;
        $mail->Body    = $this->body;
        $mail->AltBody = $this->altBody ?? "";

        return $mail->send();
    }

    private function sendWithApi(): bool
    {
        $domain = $this->envHandler->getEnv('MAIL_SERVER');

        $url = "http://" . $domain . "/SendMail";

        $data = [
            'to' => $this->to, // The email address to send to
            'from' => $this->from->value, // The email address to send from
            'subject' => $this->subject, // The email subject
            'fromName' => $this->name, // The name to send from
            'body' => $this->body, // The email body
            'altBody' => $this->altBody ?? "", // The email body
            'key' => $this->getEcryptedApiKey() // The encrypted key
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

        return $responseFromMail === "success";
    }

    private function getEcryptedApiKey(): string
    {
        $apiKey = $this->envHandler->getEnv('MAIL_API_KEY');

        $timestamp = time() - 35; // unix timestamp

        $data = $apiKey . "::" . $timestamp;

        $encryptKey = $this->envHandler->getEnv('MAIL_API_ENCRYPTKEY');

        return openssl_encrypt($data, 'AES-128-ECB', $encryptKey);
    }

    public function send(): bool
    {
        if (strtolower($this->envHandler->getEnv("MAIL_WITH_API")) === "true") {
            return $this->sendWithApi();
        } else {
            return $this->sendWithoutApi();
        }
    }
}
