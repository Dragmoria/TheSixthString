<?php

namespace Lib\MVCCore\Routers;

use Lib\MVCCore\View;

/**
 * Router interface. All routers must implement this interface.
 * 
 * @package Lib\MVCCore
 */
interface Router
{
    /**
     * Will handle the request and route it to the correct controller.
     *
     * @param Request $request The current request object.
     * @return void
     */
    public function route(Request $request): void;

    /**
     * Used to register a new route of type GET.
     *
     * @param string $uri The uri of the route.
     * @param array $callback The callback to be executed when the route is requested. Should take form of [Controller::class, 'methodToCall']
     * @return Router Router instance to allow for method chaining.
     */
    public function get(string $uri, array $callback): Router;

    /**
     * Used to register a new route of type POST.
     *
     * @param string $uri The uri of the route.
     * @param array $callback The callback to be executed when the route is requested. Should take form of [Controller::class, 'methodToCall']
     * @return Router Router instance to allow for method chaining.
     */
    public function post(string $uri, array $callback): Router;

    /**
     * Used to register a new route of type DELETE.
     *
     * @param string $uri The uri of the route.
     * @param array $callback The callback to be executed when the route is requested. Should take form of [Controller::class, 'methodToCall']
     * @return Router Router instance to allow for method chaining.
     */
    public function delete(string $uri, array $callback): Router;

    /**
     * Used to register a new route of type PATCH.
     *
     * @param string $uri The uri of the route.
     * @param array $callback The callback to be executed when the route is requested. Should take form of [Controller::class, 'methodToCall']
     * @return Router Router instance to allow for method chaining.
     */
    public function patch(string $uri, array $callback): Router;

    /**
     * Used to register a new route of type PUT.
     *
     * @param string $uri The uri of the route.
     * @param array $callback The callback to be executed when the route is requested. Should take form of [Controller::class, 'methodToCall']
     * @return Router Router instance to allow for method chaining.
     */
    public function put(string $uri, array $callback): Router;

    /**
     * Enables the use of middleware on the current route.
     *
     * @param string $middlewareName The fully qualified name of the middleware class.
     * @param array|null $middlewareParameter The parameter to be passed to the middleware constructor.
     * @return void
     */
    public function middleware(string $middlewareName, array $middlewareParameter = null): Router;

    /**
     * Enables the ability to add a view to be rendered when a specific status code is returned.
     *
     * @param HTTPStatusCodes $statusCode The status code the view should be used for.
     * @param View $view The view to be rendered. 
     * @return void
     */
    public function registerStatusView(HTTPStatusCodes $statusCode, View $view): void;

    /**
     * Enables the ability to add a view to be rendered when a status code is returned that does not have a specific view registered.
     *
     * @param View $view The view to be rendered.
     * @return void
     */
    public function registerGenericStatusView(View $view): void;
}
