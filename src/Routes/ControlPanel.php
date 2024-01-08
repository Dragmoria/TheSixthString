<?php

use Http\Controllers\ControlPanel\ManageAccountsController;
use Http\Controllers\ControlPanel\ManageBrandsController;
use Http\Controllers\ControlPanel\ManageCategoriesController;
use Http\Controllers\ControlPanel\ManageCouponsController;
use Http\Controllers\ControlPanel\ManageProductsController;
use Http\Controllers\ControlPanel\StatisticsController;
use Http\Controllers\ControlPanel\AppointmentsController;
use Http\Controllers\ControlPanel\ModerateReviewsController;
use Http\Controllers\ControlPanel\OrderManagementController;
use Http\Middlewares\SilentAuthentication;
use Lib\Enums\Role;

// Accounts
$router->get('/ControlPanel/Accounts', [ManageAccountsController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Admin]);
$router->get('/ControlPanel/Accounts/GetUsersTableData', [ManageAccountsController::class, 'getUsersTableData'])->middleware(SilentAuthentication::class, ["role" => Role::Admin]);
$router->patch('/ControlPanel/Accounts/UpdateUser', [ManageAccountsController::class, 'updateUser'])->middleware(SilentAuthentication::class, ["role" => Role::Admin]);
$router->put('/ControlPanel/Accounts/AddUser', [ManageAccountsController::class, 'addUser'])->middleware(SilentAuthentication::class, ["role" => Role::Admin]);
$router->patch('/ControlPanel/Accounts/ResetPassword', [ManageAccountsController::class, 'resetPassword'])->middleware(SilentAuthentication::class, ["role" => Role::Admin]);

// Coupons
$router->get('/ControlPanel/ManageCoupons', [ManageCouponsController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/ManageCoupons/GetCouponsTableData', [ManageCouponsController::class, 'getCouponsTableData'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->patch('/ControlPanel/ManageCoupons/UpdateCoupon', [ManageCouponsController::class, 'updateCoupon'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->put('/ControlPanel/ManageCoupons/AddNewCoupon', [ManageCouponsController::class, 'addNewCoupon'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);

// Brands
$router->get('/ControlPanel/ManageBrands', [ManageBrandsController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/ManageBrands/GetBrandsTableData', [ManageBrandsController::class, 'getBrandsTableData'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->patch('/ControlPanel/ManageBrands/UpdateBrand', [ManageBrandsController::class, 'updateBrand'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->put('/ControlPanel/ManageBrands/AddBrand', [ManageBrandsController::class, 'addBrand'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);

// Statistics
$router->get('/ControlPanel/Statistics', [StatisticsController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Analyst]);

// Appointments
$router->get('/ControlPanel/Appointments', [AppointmentsController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/Appointments/GetAppointments', [AppointmentsController::class, 'getAppointments'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);

// Categories
$router->get('/ControlPanel/ManageCategories', [ManageCategoriesController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/ManageCategories/GetCategoriesTableData', [ManageCategoriesController::class, 'getCategoriesTableData'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->put('/ControlPanel/ManageCategories/AddCategory', [ManageCategoriesController::class, 'addCategory'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->put('/ControlPanel/ManageCategories/UpdateCategory', [ManageCategoriesController::class, 'updateCategory'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);

// Products
$router->get('/ControlPanel/ManageProducts', [ManageProductsController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/ManageProducts/GetBrands', [ManageProductsController::class, 'getBrands'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/ManageProducts/GetCategories', [ManageProductsController::class, 'getCategories'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/ManageProducts/GetProductsTableData', [ManageProductsController::class, 'getProductsTableData'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->post('/ControlPanel/Products/AddProduct', [ManageProductsController::class, 'addProduct'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->post('/ControlPanel/Products/UpdateProduct', [ManageProductsController::class, 'updateProduct'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);

// Orders
$router->get('/ControlPanel/OrderManagement', [OrderManagementController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/OrderManagement/GetOrdersTableData', [OrderManagementController::class, 'getOrdersTableData'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/OrderManagement/{orderId}', [OrderManagementController::class, 'getOrderDetails'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->post('/ControlPanel/OrderManagement/{orderId}/SetShippingStatus', [OrderManagementController::class, 'setShippingStatus'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);

// Reviews
$router->get('/ControlPanel/ModerateReviews', [ModerateReviewsController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/ModerateReviews/GetReviewsTableData', [ModerateReviewsController::class, 'getReviewsTableData'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->post('/ControlPanel/ModerateReviews/SetReviewStatus', [ModerateReviewsController::class, 'setReviewStatus'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);