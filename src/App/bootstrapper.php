<?php

use Lib\MVCCore\Containers\Container;
use Lib\MVCCore\Application;
use Lib\MVCCore\Routers\HTTPStatusCodes;
use Lib\EnvUtility\EnvHandler;

use Http\Controllers\HomeController;
use Http\Controllers\AdminPanelController;
use Http\Controllers\LoginController;
use Http\Middlewares\Authenticate;
use Http\Middlewares\Roles;
use Models\DailyMessageModel;
use Models\ProductsModel;


Application::initialize();

$container = Container::getInstance();
// Register some services here. Supports singleton and transient services.
$container->registerClass(EnvHandler::class)->asSingleton()->setResolver(function() {
    return new EnvHandler(BASE_PATH . '/.env');
});
$container->registerClass(DailyMessageModel::class)->asSingleton();
$container->registerClass(ProductsModel::class)->asSingleton();

$router = Application::getRouter();
$router->registerStatusView(HTTPStatusCodes::NOT_FOUND, VIEWS_PATH . '/Errors/404.php');
// Add routes below here.

$router->get('/', [HomeController::class, 'index']);
$router->put('/', [HomeController::class, 'put']);
$router->get('/AdminPanel', [AdminPanelController::class, 'show'])->middleware(Authenticate::class, [Roles::Admin->value]);
$router->get('/Login', [LoginController::class, 'show']);
$router->get('/Logout', [LoginController::class, 'logout'])->middleware(Authenticate::class, [Roles::User->value, Roles::Admin->value]);


// Run the application.
Application::run();