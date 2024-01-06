<?php

namespace Http\Controllers;

use EmailTemplates\Mail;
use EmailTemplates\MailFrom;
use EmailTemplates\MailTemplate;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;

class ContactFormController extends Controller
{
    public function show(): ?Response
    {
        $response = new ViewResponse();

        $response->setBody(view(VIEWS_PATH . 'ContactPage.view.php')->withLayout(MAIN_LAYOUT));

        return $response;
    }

    public function send(): void
    {
        $mailtemplateContactForm = new MailTemplate(MAIL_TEMPLATES . 'ContactFormCustomer.php', [
            'message' => $_POST['message']
        ]);

        $userEmail = $_POST['email'];
        $mail = new Mail($userEmail, "Contactformulier verzonden!", $mailtemplateContactForm, MailFrom::NOREPLY, mailerName: "no-reply@thesixthstring.store");
        $mail->send();

        $mailtemplateContactFormStore = new MailTemplate(MAIL_TEMPLATES . 'ContactFormStore.php', [
            'firstname' => $_POST['firstname'],
            'lastname' => $_POST['lastname'],
            'email' => $_POST['email'],
            'message' => $_POST['message']
        ]);

        $mail = new Mail("info@thesixthstring.store", "Contactformulier ontvangen!", $mailtemplateContactFormStore, MailFrom::NOREPLY, mailerName: "no-reply@thesixthstring.store");
        $mail->send();

        redirect('/');
    }
}