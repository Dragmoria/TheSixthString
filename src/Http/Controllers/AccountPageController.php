<?php
namespace Http\Controllers;

use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;

class AccountPageController extends Controller
{
    public function AccountPage(): ?Response
    {

        $Response = new ViewResponse();
        $Response->setBody(view(VIEWS_PATH . 'AccountPage.view.php', [])->withLayout(MAIN_LAYOUT));
        return $Response;

    }

    public function Logout(): ?Response
    {
        unset($_SESSION['user']);
        redirect('/Login');
        
    }


}



















?>