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

    public function __construct(string $to, string $subject, MailTemplate $body, MailFrom $from, string $mailerName, ?MailTemplate $altBody = null)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->body = $body->render();
        $this->altBody = $altBody?->render();
        $this->from = $from;

        $env = Application::resolve(EnvHandler::class);

        $this->password = $env->getEnv('MAIL_PASSWORD_' . $this->from->getName());

        $this->name = $mailerName;
    }

    public function send(): bool
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug  = 2;                   //Send using SMTP
        $mail->Host       = 'smtp-mail.outlook.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $this->from->value;                     //SMTP username
        $mail->Password   = $this->password;                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Mail versturen settings
        $mail->setFrom($mail->Username, $this->name);
        $mail->addAddress($this->to);     //Add a recipient
        $mail->addReplyTo('info@thesixthstring.store', 'Information');


        $mail->isHTML(true);
        $mail->Subject = $this->subject;
        $mail->Body    = $this->body;
        $mail->AltBody = $this->altBody ?? "";

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            error_log($mail->ErrorInfo);
            exit;
        }

        return $mail->send();
    }
}
