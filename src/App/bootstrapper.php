<?php

use Http\Controllers\HomeController;
use Lib\MVCCore\Containers\Container;
use Lib\MVCCore\Application;
use Lib\EnvUtility\EnvHandler;
use Service\ReviewService;
use Http\Controllers\ReviewController;

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
//$router->get('/', [HomeController::class, 'index']);
$router->get('/', [ReviewController::class, 'index']);


// Run the application.
Application::run();