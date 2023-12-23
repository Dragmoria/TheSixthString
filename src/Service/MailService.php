<?php

namespace Service;

use EmailTemplates\MailTemplate;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class MailService
{
    public function __construct()
    {
    }

    public function test(string $sender,string $password,string $displayname)
    {
        $mail = new PHPMailer();
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp-mail.outlook.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $sender;                    //SMTP username
        $mail->Password   = $password;                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Mail versturen settings
        $mail->setFrom($mail->Username, $displayname);
        $mail->addAddress('jarnogerrets@gmail.com');     //Add a recipient
        // $mail->addReplyTo('info@thesixthstring.store', 'Information');

        //Content ww veranderen -> moet je schrijven in html
        $mail->isHTML(true);
        $mail->Subject = 'Wachtwoord vergeten';
        $mail->Body    = 'Het werkt!!! <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        try {
            //feedback
            $mail->send();
            echo 'Message has been sent';
        } catch (\Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function send(MailTemplate $mailTemplate): void
    {
    }
}
