<?php

use Http\Controllers\ControlPanel\ManageAccountsController;
use Http\Controllers\ControlPanel\ControlPanelController;
use Http\Controllers\ControlPanel\ManageBrandsController;
use Http\Controllers\ControlPanel\ManageCategoriesController;
use Http\Controllers\ControlPanel\ManageCouponsController;
use Http\Controllers\ControlPanel\ManageProductsController;
use Http\Controllers\ControlPanel\StatisticsController;
use Http\Controllers\ControlPanel\AppointmentsController;
use Http\Middlewares\SilentAuthentication;
use Lib\Enums\Role;

$router->get('/ControlPanel', [ControlPanelController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Analyst]);
$router->get('/ControlPanel/Accounts', [ManageAccountsController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Admin]);
$router->get('/ControlPanel/Accounts/GetUsersTableData', [ManageAccountsController::class, 'getUsersTableData'])->middleware(SilentAuthentication::class, ["role" => Role::Admin]);
$router->patch('/ControlPanel/Accounts/UpdateUser', [ManageAccountsController::class, 'updateUser'])->middleware(SilentAuthentication::class, ["role" => Role::Admin]);
$router->put('/ControlPanel/Accounts/AddUser', [ManageAccountsController::class, 'addUser'])->middleware(SilentAuthentication::class, ["role" => Role::Admin]);
$router->patch('/ControlPanel/Accounts/ResetPassword', [ManageAccountsController::class, 'resetPassword'])->middleware(SilentAuthentication::class, ["role" => Role::Admin]);
$router->get('/ControlPanel/ManageCoupons', [ManageCouponsController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/ManageCoupons/GetCouponsTableData', [ManageCouponsController::class, 'getCouponsTableData'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->patch('/ControlPanel/ManageCoupons/UpdateCoupon', [ManageCouponsController::class, 'updateCoupon'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->put('/ControlPanel/ManageCoupons/AddNewCoupon', [ManageCouponsController::class, 'addNewCoupon'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/ManageProducts', [ManageProductsController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/ManageBrands', [ManageBrandsController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/ManageBrands/GetBrandsTableData', [ManageBrandsController::class, 'getBrandsTableData'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->patch('/ControlPanel/ManageBrands/UpdateBrand', [ManageBrandsController::class, 'updateBrand'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->put('/ControlPanel/ManageBrands/AddBrand', [ManageBrandsController::class, 'addBrand'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/Statistics', [StatisticsController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Analyst]);


$router->get('/ControlPanel/Appointments', [AppointmentsController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/Appointments/GetAppointments', [AppointmentsController::class, 'getAppointments'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);


$router->get('/ControlPanel/ManageCategories', [ManageCategoriesController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/ManageCategories/GetCategoriesTableData', [ManageCategoriesController::class, 'getCategoriesTableData'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->put('/ControlPanel/ManageCategories/AddCategory', [ManageCategoriesController::class, 'addCategory'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->put('/ControlPanel/ManageCategories/UpdateCategory', [ManageCategoriesController::class, 'updateCategory'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);

$router->get('/TestSomething/TestMail', [ControlPanelController::class, 'testMail']);
