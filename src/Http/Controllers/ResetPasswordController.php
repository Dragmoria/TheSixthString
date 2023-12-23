<?
namespace Http\Controllers;

use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\HTTPStatusCodes;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\TextResponse;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Lib\MVCCore\Application;
use Service\ResetpasswordService;
use Service\RandomLinkService;




class ResetPasswordController extends Controller {
    public function ResetPassword($urlData): ?Response 
    {
        $Response = new ViewResponse();
        $Response->setBody(view(VIEWS_PATH . 'ResetPassword.view.php', [])->withLayout(VIEWS_PATH . 'Layouts/Main.layout.php'));
        $resetPasswordService = Application::resolve(RandomLinkService::class);
        return $Response;
        
    }
}

/*
daar komt dan een array uit

[
    'dynamicLink' => '02340983298490218490'
]

zoiets
*/