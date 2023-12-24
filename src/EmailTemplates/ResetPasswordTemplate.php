<?


namespace EmailTemplates;

class ResetPasswordTemplate
{

    public function ResetPasswordTemplate($token)
    {

        $body = "<h1>Hallo daar password resetter</h1>
            <p>
            Klik op de link om je wachtwoord te resetten:
            <a href=http://localhost:8080/ResetPassword/" . $token . ">Reset password</a>
            </p>";
        return $body;

    }
}







?>