<?php

use Http\Controllers\ControlPanel\ManageAccountsController;
use Http\Controllers\ControlPanel\ControlPanelController;
use Http\Controllers\ControlPanel\ManageContentController;
use Http\Controllers\ControlPanel\ManageCouponsController;
use Http\Controllers\ControlPanel\ModerateReviewsController;
use Http\Controllers\ControlPanel\OrderManagementController;
use Http\Controllers\ControlPanel\StatisticsController;
use Http\Controllers\HomeController;
use Http\Controllers\JeMoederController;
use Http\Middlewares\SilentAuthentication;
use Lib\Enums\Role;
use Lib\EnvUtility\EnvHandler;
use Lib\MVCCore\Application;
use Lib\MVCCore\Containers\Container;
use Service\CategoryService;
use Service\CouponService;
use Service\ResetpasswordService;
use Service\ReviewService;
use Service\UserService;

Application::initialize();

date_default_timezone_set('Europe/Amsterdam'); // Replace 'Europe/Amsterdam' with your timezone

$container = Container::getInstance();
// Register some services here. Supports singleton and transient services.
$container->registerClass(EnvHandler::class)->asSingleton()->setResolver(function () {
    return new EnvHandler(BASE_PATH . '/.env');
});
$container->registerClass(ReviewService::class)->asSingleton();
$container->registerClass(CategoryService::class)->asSingleton();
$container->registerClass(UserService::class)->asSingleton();
$container->registerClass(ResetpasswordService::class)->asSingleton();
$container->registerClass(CouponService::class)->asSingleton();


$router = Application::getRouter();
//$router->registerStatusView(HTTPStatusCodes::NOT_FOUND, VIEWS_PATH . '/Errors/404.php');

// Add routes below here.
$router->get('/', [HomeController::class, 'index']);

$router->get('/ControlPanel', [ControlPanelController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Analyst]);
$router->get('/ControlPanel/Accounts', [ManageAccountsController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Admin]);
$router->get('/ControlPanel/Statistics', [StatisticsController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Analyst]);
$router->get('/ControlPanel/ManageContent', [ManageContentController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/ModerateReviews', [ModerateReviewsController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/OrderManagement', [OrderManagementController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/Accounts/UsersTableData', [ManageAccountsController::class, 'usersTableData'])->middleware(SilentAuthentication::class, ["role" => Role::Admin]);
$router->patch('/ControlPanel/Accounts/UpdateUser', [ManageAccountsController::class, 'updateUser'])->middleware(SilentAuthentication::class, ["role" => Role::Admin]);
$router->put('/ControlPanel/Accounts/AddUser', [ManageAccountsController::class, 'addUser'])->middleware(SilentAuthentication::class, ["role" => Role::Admin]);
$router->patch('/ControlPanel/Accounts/ResetPassword', [ManageAccountsController::class, 'resetPassword'])->middleware(SilentAuthentication::class, ["role" => Role::Admin]);
$router->get('/ControlPanel/ManageCoupons', [ManageCouponsController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/ManageCoupons/GetCoupons', [ManageCouponsController::class, 'getCoupons'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->patch('/ControlPanel/ManageCoupons/UpdateCoupon', [ManageCouponsController::class, 'updateCoupon'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->put('/ControlPanel/ManageCoupons/AddNewCoupon', [ManageCouponsController::class, 'addNewCoupon'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);


$router->get('/test/{id}/{id}', [JeMoederController::class, 'test']);


$_SESSION["user"] = ["role" => Role::Admin->value];

// Run the application.
Application::run();
