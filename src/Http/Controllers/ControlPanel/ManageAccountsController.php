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
use Models\ResetpasswordModel;
use Models\UserModel;
use Service\ResetpasswordService;
use Service\UserService;
use Validators\Validate;

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

        $toUpdateUser = $userService->getUserById($this->currentRequest->postObject->body()['id']);

        $postBody = $this->currentRequest->postObject->body();

        $errors = $this->validateUser($postBody);

        if (count($errors) > 0) {
            $response = new JsonResponse();
            $response->setBody($errors);
            return $response;
        }

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

        $postBody = $this->currentRequest->postObject->body();

        $errors = $this->validateNewUser($postBody);

        if (count($errors) > 0) {
            $response = new JsonResponse();
            $response->setBody($errors);
            return $response;
        }

        $newUser = new UserModel();
        $newUser->role = Role::Staff;
        $newUser->emailAddress = $postBody['newEmail'];
        $newUser->firstName = $postBody['newFirstName'];
        $newUser->insertion = $postBody['newInsertion'];
        $newUser->lastName = $postBody['newLastName'];
        $newUser->dateOfBirth = new \DateTime($postBody['newDateOfBirth']);
        $newUser->gender = Gender::fromString($postBody['newGender']);
        $newUser->active = false;
        $newUser->createdOn = new \DateTime();
        $newUser->passwordHash = password_hash($this->randomString(22), PASSWORD_DEFAULT);

        $createdUser = $userService->createUser($newUser);

        $resetpasswordService = Application::resolve(ResetpasswordService::class);

        $resetpasswordModel = new ResetpasswordModel();
        $resetpasswordModel->user = $createdUser;
        $resetpasswordModel->link = $this->randomString(32);
        $resetpasswordModel->validUntil = new \DateTime('+1 day');

        $resetpasswordService->newResetpassword($resetpasswordModel);

        $response = new TextResponse();
        $response->setBody("User created");
        return $response;
    }

    public function resetPassword(): ?Response
    {
        $userService = Application::resolve(UserService::class);

        $user = $userService->getUserById($this->currentRequest->postObject->body()['id']);

        $resetpasswordService = Application::resolve(ResetpasswordService::class);

        $resetpasswordModel = new ResetpasswordModel();
        $resetpasswordModel->user = $user;
        $resetpasswordModel->link = $this->randomString(32);
        $resetpasswordModel->validUntil = new \DateTime('+1 day');

        $resetpasswordService->newResetpassword($resetpasswordModel);

        $response = new TextResponse();
        $response->setBody("Password reset");
        return $response;
    }

    private function randomString(int $charCount): string
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $charCount; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function validateNewUser($postBody): array
    {
        $errors = [];

        if (!Validate::email($postBody['newEmail'])) {
            $errors[] = ["field" => "newEmail", "message" => "Email is niet geldig"];
        }

        if (!Validate::notEmpty($postBody['newFirstName'])) {
            $errors[] = ["field" => "newFirstName", "message" => "Voornaam is leeg"];
        }

        if (!Validate::notEmpty($postBody['newLastName'])) {
            $errors[] = ["field" => "newLastName", "message" => "Achternaam is leeg"];
        }

        if (!Validate::notEmpty($postBody['newDateOfBirth'])) {
            $errors[] = ["field" => "newDateOfBirth", "message" => "Geboortedatum is leeg"];
        }

        if (!Validate::genderString($postBody['newGender'])) {
            $errors[] = ["field" => "newGender", "message" => "Ontvangen geslagd is niet in geldig format"];
        }

        if (!Validate::dateString($postBody['newDateOfBirth'])) {
            $errors[] = ["field" => "newDateOfBirth", "message" => "Geboortedatum is niet in geldig formaat"];
        }

        return $errors;
    }

    public function validateUser($postBody): array
    {
        $errors = [];

        if (!Validate::notEmpty($postBody['firstName'])) {
            $errors[] = ["field" => "firstName", "message" => "Voornaam is leeg"];
        }

        if (!Validate::notEmpty($postBody['lastName'])) {
            $errors[] = ["field" => "lastName", "message" => "Achternaam is leeg"];
        }

        if (!Validate::notEmpty($postBody['dateOfBirth'])) {
            $errors[] = ["field" => "dateOfBirth", "message" => "Geboortedatum is leeg"];
        }

        if (!Validate::genderString($postBody['gender'])) {
            $errors[] = ["field" => "gender", "message" => "Ontvangen geslagd is niet in geldig format"];
        }

        if (!Validate::dateString($postBody['dateOfBirth'])) {
            $errors[] = ["field" => "dateOfBirth", "message" => "Geboortedatum is niet in geldig formaat"];
        }

        if (!Validate::roleString($postBody['role'])) {
            $errors[] = ["field" => "role", "message" => "Ontvangen rol is niet in geldig format"];
        }

        return $errors;
    }
}
