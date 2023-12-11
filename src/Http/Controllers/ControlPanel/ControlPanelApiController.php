<?php

namespace Http\Controllers\ControlPanel;

use Lib\MVCCore\Application;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\HTTPStatusCodes;
use Lib\MVCCore\Routers\Responses\JsonResponse;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\TextResponse;
use Service\UserService;

class ControlPanelApiController extends Controller
{
    public function select($apiKey): ?Response
    {
        if (method_exists($this, $apiKey)) {
            return call_user_func([$this, $apiKey]);
        } else {
            // Handle the case where there is no method with the name in $apiKey
            $response = new TextResponse();
            $response->setBody("This api does not exists.");
            $response->setStatusCode(HTTPStatusCodes::NOT_FOUND);
            return $response;
        }
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
            unset($userJson['id']);

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
}
