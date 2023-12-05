<?php

use Lib\MVCCore\Containers\Container;
use Lib\MVCCore\Application;
use Lib\MVCCore\Routers\HTTPStatusCodes;
use Lib\EnvUtility\EnvHandler;
use Service\BaseDatabaseService;

Application::initialize();

$container = Container::getInstance();
// Register some services here. Supports singleton and transient services.
$container->registerClass(EnvHandler::class)->asSingleton()->setResolver(function() {
    return new EnvHandler(BASE_PATH . '/.env');
});
$container->registerClass(BaseDatabaseService::class)->asSingleton();

$router = Application::getRouter();
$router->registerStatusView(HTTPStatusCodes::NOT_FOUND, VIEWS_PATH . '/Errors/404.php');
// Add routes below here.


// Run the application.
Application::run();