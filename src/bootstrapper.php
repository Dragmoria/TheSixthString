<?php

use Http\Controllers\ControlPanel\AccountsController;
use Http\Controllers\ControlPanel\ControlPanelController;
use Http\Controllers\ControlPanel\ManageContentController;
use Http\Controllers\ControlPanel\ManageVouchersController;
use Http\Controllers\ControlPanel\ModerateReviewsController;
use Http\Controllers\ControlPanel\OrderManagementController;
use Http\Controllers\ControlPanel\StatisticsController;
use Http\Controllers\HomeController;
use Http\Middlewares\SilentAuthentication;
use Lib\Enums\Role;
use Lib\EnvUtility\EnvHandler;
use Lib\MVCCore\Application;
use Lib\MVCCore\Containers\Container;
use Service\ReviewService;

Application::initialize();

$container = Container::getInstance();
// Register some services here. Supports singleton and transient services.
$container->registerClass(EnvHandler::class)->asSingleton()->setResolver(function() {
    return new EnvHandler(BASE_PATH . '/.env');
});
$container->registerClass(ReviewService::class)->asSingleton();

$router = Application::getRouter();
//$router->registerStatusView(HTTPStatusCodes::NOT_FOUND, VIEWS_PATH . '/Errors/404.php');

// Add routes below here.
$router->get('/', [HomeController::class, 'index']);

$router->get('/ControlPanel', [ControlPanelController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Analyst]);
$router->get('/ControlPanel/Accounts', [AccountsController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Admin]);
$router->get('/ControlPanel/Statistics', [StatisticsController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Analyst]);
$router->get('/ControlPanel/ManageContent', [ManageContentController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/ManageVouchers', [ManageVouchersController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/ModerateReviews', [ModerateReviewsController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/OrderManagement', [OrderManagementController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);


$_SESSION["user"] = ["role" => Role::Admin->value];

// Run the application.
Application::run();