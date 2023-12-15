<?php

use Http\Controllers\HomeController;
use http\controllers\RegisterController;
use http\controllers\LoginController;
use Lib\MVCCore\Containers\Container;
use Lib\MVCCore\Application;
use Lib\MVCCore\Routers\HTTPStatusCodes;
use Lib\EnvUtility\EnvHandler;

Application::initialize();

$container = Container::getInstance();
// Register some services here. Supports singleton and transient services.
$container->registerClass(EnvHandler::class)->asSingleton()->setResolver(function() {
    return new EnvHandler(BASE_PATH . '/.env');
});

$router = Application::getRouter();

// Add routes below here.
$router->get('/Register', [RegisterController::class, 'register']);
$router->get('/Login', [LoginController::class, 'loginPage']);
$router->put('/', [RegisterController::class, 'put']);
$router->post('/RegisterSucces',[RegisterController::class, 'post']);
$router->post('/Account', [LoginController::class, 'post']);

// Run the application.
Application::run();