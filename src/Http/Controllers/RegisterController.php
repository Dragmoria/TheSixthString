<?php
namespace Http\Controllers;

use Lib\Enums\Role;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;

class RegisterController extends Controller
{
    public function register(): ?Response
    {
        $Response = new ViewResponse();
        $Response->setBody(view(VIEWS_PATH . 'Register.view.php', [])->withLayout(VIEWS_PATH . 'Layouts/Main.layout.php'));
        return $Response;
    }

    public function get(): ?Response
    {
        $request = $this->currentRequest;
        if ($request->hasPostObject()) {
            //dumpDie($request->getPostObject()->body());
        }
    }


class UserService extends BaseDatabaseService
{
    public function addUser(UserModel $model): void {
        $userQuery = "insert into user (firstname, lastname) values ('?', '?')";
        $result = $this->executeQuery($userQuery, [$model->firstName, $model->lastName]);
        $userId = 1;
        $invoiceAddressQuery = "insert into address (street, city, type) values('?', '?', '?')";
        $this->executeQuery($invoiceAddressQuery, [$model->address->street, $model->address->city, AddressType::Invoice->value]);
        $shippingAddressQuery = "insert into address (street, city, type) values('?', '?', '?')";
        $this->executeQuery($shippingAddressQuery, [$model->address->street, $model->address->city, AddressType::Shipping->value]);
    }

    public function SaveUser() :?Response
    {

        $postBody = $this->currentRequest->getPostObject()->body();

        $usermodel = new UserModel();
        $usermodel->emailAddress = $postbody('username');
        $usermodel->passwordHash = $postbody('password');
        $usermodel->role = Role::Customer;
        $usermodel->firstName = $postbody('firstname');
        $usermodel->insertion = $postbody('middlename');
        $usermodel->lastName = $postbody('lastname');
        $usermodel->dateOfBirth = $postbody('birthdate');
        $usermodel->gender = $postbody('gender');
        $usermodel->street = $postbody('street');
        $usermodel->housenumber = $postbody('housenumber');
        $usermodel->$housenumberExtension = $postbody('addition');
        $usermodel->zipcode = $postbody('zipcode');
        $usermodel->city = $postbody('city');
        $usermodel->country = $postbody('country');
        
    }



    public function createUser(UserModel $input): UserModel
    {
        $query = "INSERT INTO user (`emailAddress`, `passwordHash`, `role`, `firstName`, `insertion`, `lastName`, `dateOfBirth`, `gender`, `active`, `createdOn`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

        $params = [
            $input->emailAddress,
            $input->passwordHash,
            $input->role->value,
            $input->firstName,
            $input->insertion,
            $input->lastName,
            $input->dateOfBirth->format('Y-m-d'),
            $input->gender->value,
            $input->active,
            $input->createdOn->format('Y-m-d H:i:s')
        ];

        $result = $this->executeQuery($query, $params);

        // return the just created user after getting it from the database
        $user = $this->getByEmail($input->emailAddress);
        return UserModel::convertToModel($user);
    }




?>