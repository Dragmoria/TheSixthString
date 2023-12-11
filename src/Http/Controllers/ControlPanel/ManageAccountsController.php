<?php

namespace Http\Controllers\ControlPanel;

use Lib\Enums\Gender;
use Lib\Enums\Role;
use Lib\MVCCore\Application;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\JsonResponse;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\TextResponse;
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
        ])->withLayout(CONTROLPANEL_LAYOUT));

        return $response;
    }

    public function usersTableData(): ?Response
    {
        $params = $this->currentRequest->urlQueryParams();
        $search = $params['search'];
        $offset = $params['offset'];
        $limit = $params['limit'];

        $userService = Application::resolve(UserService::class);

        $users = $userService->getEmployees();
        $usersJson = [];

        foreach ($users as $user) {
            $userJson = (array) $user;
            $userJson['createdOn'] = $user->createdOn->format('d-m-Y');
            $userJson['dateOfBirth'] = $user->dateOfBirth->format('d-m-Y');
            $userJson['role'] = $user->role->toString();
            $userJson['gender'] = $user->gender->toString();
            unset($userJson['passwordHash']);

            // Maak een string van alle velden en kijk of search daar in zit
            if (stristr(implode(' ', $userJson), $search)) {
                $usersJson[] = $userJson;
            }
        }

        // Apply offset and limit
        $usersJson = array_slice($usersJson, $offset, $limit);

        $response = new JsonResponse();

        $response->setBody([
            "total" => count($users),
            "rows" => $usersJson
        ]);

        return $response;
    }

    public function updateUser(): ?Response
    {
        $userService = Application::resolve(UserService::class);

        $toUpdateUser = $userService->getUserById($this->currentRequest->getPostObject()->body()['id']);

        $postBody = $this->currentRequest->getPostObject()->body();

        $toUpdateUser->id = $postBody['id'];
        $toUpdateUser->role = Role::fromString($postBody['role']);
        $toUpdateUser->firstName = $postBody['firstName'];
        $toUpdateUser->insertion = $postBody['insertion'];
        $toUpdateUser->lastName = $postBody['lastName'];
        $toUpdateUser->dateOfBirth = new \DateTime($postBody['dateOfBirth']);
        $toUpdateUser->gender = Gender::fromString($postBody['gender']);

        $userService->updateUser($toUpdateUser);

        $response = new TextResponse();

        $response->setBody("User updated");
        return $response;
    }

    public function addUser(): ?Response
    {
        $userService = Application::resolve(UserService::class);

        $postBody = $this->currentRequest->getPostObject()->body();

        $newUser = new UserModel();
        $newUser->role = Role::fromString($postBody['role']);
        $newUser->emailAddress = $postBody['email'];
        $newUser->firstName = $postBody['firstName'];
        $newUser->insertion = $postBody['insertion'];
        $newUser->lastName = $postBody['lastName'];
        $newUser->dateOfBirth = new \DateTime($postBody['dateOfBirth']);
        $newUser->gender = Gender::fromString($postBody['gender']);
        $newUser->active = false;
        $newUser->createdOn = new \DateTime();
        $newUser->passwordHash = password_hash($postBody['password'], PASSWORD_DEFAULT);

        $userService->createUser($newUser);

        $response = new TextResponse();
        $response->setBody("User created");
        return $response;
    }
}
