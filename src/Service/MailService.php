<?

namespace Service;

use PHPMailer\src\PHPMailer;
use PHPMailer\src\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

//Server settings

    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    // $mail->isSMTP();                                            //Send using SMTP
    // $mail->Host       = 'smtp-mail.outlook.com';                     //Set the SMTP server to send through
    // $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    // $mail->Username   = 'no-reply@thesixthstring.store';                     //SMTP username
    // $mail->Password   = '(ww invullen van account)';                               //SMTP password
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    // $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

	// //Mail versturen settings
	// $mail->setFrom('no-reply@thesixthstring', 'Mailer');
    // $mail->addAddress((mail van klant))    //Add a recipient
    // $mail->addReplyTo('info@thesixthstring.store', 'Information');
	
	// //Content ww veranderen -> moet je schrijven in html
	// $mail->isHTML(true);                                  
    // $mail->Subject = 'Wachtwoord vergeten';
    // $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	// //feedback
    // $mail->send();
    // echo 'Message has been sent';
	// } catch (Exception $e) {
    // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	// }
















?>