<?php

namespace Http\Controllers\ControlPanel;

use Lib\Enums\Gender;
use Lib\Enums\Role;
use Lib\MVCCore\Application;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Models\UserModel;
use Service\UserService;

class ManageAccountsController extends Controller
{
    public function show(): ?Response
    {
        $response = new ViewResponse();

        $userService = Application::resolve(UserService::class);

        $users = $userService->getUsersByRole(Role::Admin);

        $response->setBody(view(VIEWS_PATH . '/ControlPanel/ManageAccounts.view.php', [
            "users" => $users
        ])->withLayout(MAIN_LAYOUT));

        return $response;
    }
}
