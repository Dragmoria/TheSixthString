<?php

namespace Lib\MVCCore\Routers;

use Lib\MVCCore\View;
use Lib\MVCCore\Routers\Responses\ViewResponse;

/**
 * A router is used to register routes and then route the request to the correct controller.
 * 
 * @package Lib\MVCCore
 */
class CoreRouter implements Router
{
    /**
     * Array of registered routes.
     *
     * @var array
     */
    protected array $routes = [];

    /**
     * Array of registered http status views.
     *
     * @var array
     */
    protected array $registeredStatusViews = [];

    /**
     * Adds a route to the routes array.
     *
     * @param RequestTypes $method The request type of the route.
     * @param string $uri The uri of the route.
     * @param array $callback The callback of the route.
     * @return Router Returns itself so it can be chained.
     */
    protected function addRoute(RequestTypes $method, string $uri, array $callback): Router
    {
        $methodType = $method->value;

        $this->routes[$methodType][$uri] = ["callback" => $callback, "middlewares" => []];

        return $this;
    }

    /**
     * Used to register a new route of type GET.
     *
     * @param string $uri The uri of the route.
     * @param array $callback The callback to be executed when the route is requested. Should take form of [Controller::class, 'methodToCall']
     * @return Router Router instance to allow for method chaining.
     */
    public function get(string $uri, array $callback): Router
    {
        return $this->addRoute(RequestTypes::GET, $uri, $callback);
    }

    /**
     * Used to register a new route of type POST.
     *
     * @param string $uri The uri of the route.
     * @param array $callback The callback to be executed when the route is requested. Should take form of [Controller::class, 'methodToCall']
     * @return Router Router instance to allow for method chaining.
     */
    public function post(string $uri, array $callback): Router
    {
        return $this->addRoute(RequestTypes::POST, $uri, $callback);
    }

    /**
     * Used to register a new route of type DELETE.
     *
     * @param string $uri The uri of the route.
     * @param array $callback The callback to be executed when the route is requested. Should take form of [Controller::class, 'methodToCall']
     * @return Router Router instance to allow for method chaining.
     */
    public function delete(string $uri, array $callback): Router
    {
        return $this->addRoute(RequestTypes::DELETE, $uri, $callback);
    }

    /**
     * Used to register a new route of type PATCH.
     *
     * @param string $uri The uri of the route.
     * @param array $callback The callback to be executed when the route is requested. Should take form of [Controller::class, 'methodToCall']
     * @return Router Router instance to allow for method chaining.
     */
    public function patch(string $uri, array $callback): Router
    {
        return $this->addRoute(RequestTypes::PATCH, $uri, $callback);
    }

    /**
     * Used to register a new route of type PUT.
     *
     * @param string $uri The uri of the route.
     * @param array $callback The callback to be executed when the route is requested. Should take form of [Controller::class, 'methodToCall']
     * @return Router Router instance to allow for method chaining.
     */
    public function put(string $uri, array $callback): Router
    {
        return $this->addRoute(RequestTypes::PUT, $uri, $callback);
    }

    public function testRoute($method, $path): void
    {
        $routesToSearch = $this->routes[$method];
    }

    /**
     * Will handle the request and route it to the correct controller.
     *
     * @param Request $request The current request object.
     * @return void
     */
    public function route(Request $request): void
    {
        $methodType = $request->method()->value;
        $uri = $request->path();

        foreach ($this->routes[$methodType] as $pattern => $route) {
            // will replace the possible dynamic part of a route with a regex so we can match it with te given url
            $pattern = preg_replace('/{[^}]+}/', '([^/]+)', $pattern);

            // preg match will see if the route matches to the given url ([^/]+) will match anything except a / so it basically makes it so that a route with {id} will match anything at that spot
            if (preg_match('#^' . $pattern . '$#', $uri, $matches)) {
                // will make it so the only element in the array is the id so we can possibly pass it to the controller
                array_shift($matches);
                // will get the callback from the route
                $callback = $route['callback'];
                // will get the middlewares from the route
                $middlewares = $route['middlewares'] ?? null;

                // will loop over the middlewares and execute them if there are any
                if ($middlewares !== null) {
                    foreach ($middlewares as $middleware) {
                        // creates the middleware with the given parameters
                        $middlewareInstance = new $middleware['name']($middleware['parameters']);
                        // calls the handle method on the middleware
                        $middlewareResponse = $middlewareInstance->handle();
                        // if the middleware returns a response we will send it and stop the execution of the route
                        if ($middlewareResponse !== null) {
                            $this->abort($middlewareResponse);
                            return;
                        }
                    }
                }

                // creates the controller
                $controller = new $callback[0];
                // calls the method on the controller
                $controllerMethod = $callback[1];

                $controller->setRequest($request);
                // passes the id to the controller, if the array is emtpy it will still pass it but the controller method doesn't care about it
                $controllerReturn = $controller->$controllerMethod(...$matches);

                // if the controller returns a response we will send it and stop the execution of the route
                if ($controllerReturn !== null) {
                    $controllerReturn->send();
                    return;
                }

                $response = $controller->getResponse();
                // if the controller returns a response we will send it and stop the execution of the route
                if ($response !== null) {
                    $response->send();
                }
                return;
            }
        }
        // if no route is found we will abort the request with a 404
        $this->abort(HTTPStatusCodes::NOT_FOUND);
    }


    /**
     * Enables the use of middleware on the current route.
     *
     * @param string $middlewareName The fully qualified name of the middleware class.
     * @param array|null $middlewareParameter The parameter to be passed to the middleware constructor.
     * @return void
     */
    public function middleware(string $middlewareName, array $middlewareParameter = null): Router
    {
        reset($this->routes['GET']);
        end($this->routes['GET']);
        $key = key($this->routes['GET']);

        $this->routes['GET'][$key]['middlewares'][] = ['name' => $middlewareName, 'parameters' => $middlewareParameter];
        return $this;
    }

    /**
     * Enables the ability to add a view to be rendered when a specific status code is returned.
     *
     * @param HTTPStatusCodes $statusCode The status code the view should be used for.
     * @param View $view The view to be rendered. 
     * @return void
     */
    public function registerStatusView(HTTPStatusCodes $statusCode, View $viewName): void
    {
        $this->registeredStatusViews[$statusCode->value] = $viewName;
    }

    /**
     * Enables the ability to add a view to be rendered when a status code is returned that does not have a specific view registered.
     *
     * @param View $view The view to be rendered.
     * @return void
     */
    public function registerGenericStatusView(View $viewName): void
    {
        $this->registeredStatusViews['generic'] = $viewName;
    }

    /**
     * Aborts the current request and renders a view for the given status code.
     *
     * @param HTTPStatusCodes $statusCode The status code to render the view for.
     * @return void
     */
    protected function abort(HTTPStatusCodes $statusCode): void
    {
        // Check if a view is registered for the given status code
        if (!isset($this->registeredStatusViews[$statusCode->value])) {
            // Check if a generic view is registered
            if (isset($this->registeredStatusViews['generic'])) {
                $this->sendStatusView($statusCode, $this->registeredStatusViews['generic']);
                return;
            }

            // echo a basic string error message and return so it quits this method
            http_response_code($statusCode->value);
            echo "Error: No view registered for status code: " . $statusCode->value;
            return;
        }

        $this->sendStatusView($statusCode, $this->registeredStatusViews[$statusCode->value]);
    }

    private function sendStatusView(HTTPStatusCodes $statusCode, View $view): void
    {
        // Create the response
        $response = new ViewResponse();

        // Set the status code
        $response->setStatusCode($statusCode);

        // Render the view and set it as the body of the response
        $response->setBody($view);

        // Send the response
        $response->send();
    }
}
