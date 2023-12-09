<?php

namespace Lib\MVCCore;

use Lib\MVCCore\Containers\Container;
use Lib\MVCCore\Routers\CoreRouter;
use Lib\MVCCore\Routers\Router;
use Lib\MVCCore\Routers\Request;

/**
 * Main class of the application. This is where everything starts.
 * 
 * @package Lib\MVCCore
 */
class Application {
    /**
     * Is supposed to be the only instance of the container.
     *
     * @var Container
     */
    protected static Container $container;
    /**
     * Is supposed to be the only instance of the router.
     *
     * @var Router
     */
    protected static Router $router;
    /**
     * Is supposed to be the only instance of the request.
     *
     * @var Request
     */
    protected static Request $request;

    /**
     * Starts the session and sets the request, container and router. Needs to be called or nothing will happen.
     *
     * @return void
     */
    public static function initialize(): void {
        session_start();
        self::$request = Request::getInstance();
        self::$container = Container::getInstance();
        self::$router = new CoreRouter();
    }

    /**
     * Returns the router instance.
     *
     * @return Router
     */
    public static function getRouter(): Router {
        return self::$router;
    }

    /**
     * Returns the container instance.
     *
     * @return Container
     */
    public static function getContainer(): Container {
        return self::$container;
    }

    /**
     * Proxy method to the container resolve method. This is used to resolve dependencies.
     *
     * @param string $target The target identifier to resolve.
     * @return mixed Mixed since it can return any of the registered services.
     */
    public static function resolve(string $target): mixed {
        return self::$container->resolve($target);
    }

    /**
     * Runs the application. This will start the router and route the request.
     *
     * @return void
     */
    public static function run(): void {
        self::$router->route(self::$request);
    }

    private function __construct() {}
}