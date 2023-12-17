<?php
namespace Http\Controllers;


use Lib\MVCCore\Application;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Service\UserService;

class LoginController extends Controller{
    public function loginPage(): ?Response{
        $Response = new ViewResponse();
        $Response->setBody(view(VIEWS_PATH . 'loginPage.view.php', [] )->withLayout(VIEWS_PATH . 'Layouts/Main.layout.php'));
        return $Response;
    }



public function post() : ?Response{
redirect('/Account');
}

public function validateLogin() : ?Response{
    $userservice = Application::resolve(UserService::class);
    $user = $userservice->getUserByEmail($email = $_POST["email"]);

    
    $_SESSION["user"] = [
        "id" => $user->id,
        "role" => $user->role
   ];


}



}


?>