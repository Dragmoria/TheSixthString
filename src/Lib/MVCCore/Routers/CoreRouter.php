<?php

namespace Lib\MVCCore\Routers;

use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
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
        $uri = strtolower($uri);

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



    /**
     * Will handle the request and route it to the correct controller.
     *
     * @param Request $request The current request object.
     * @return void
     */
    public function route(Request $request): void
    {
        $methodType = $request->method()->value;
        $uri = strtolower($request->path());

        if (!$this->processRoutes($methodType, $uri, $request)) {
            $this->abort(HTTPStatusCodes::NOT_FOUND);
        }
    }

    /**
     * Processes the routes and executes the correct controller.
     *
     * @param string $methodType
     * @param string $uri
     * @param Request $request
     * @return bool
     */
    private function processRoutes(string $methodType, string $uri, Request $request): bool
    {
        foreach ($this->routes[$methodType] as $pattern => $route) {
            $pattern = $this->replaceDynamicPartOfRoute($pattern);

            list($isMatch, $matches) = $this->routeMatches($pattern, $uri);

            if ($isMatch) {
                $callback = $route['callback'];
                $middlewares = $route['middlewares'] ?? null;

                if ($this->executeMiddlewares($middlewares)) {
                    return true;
                }

                $controller = $this->createController($callback, $request);

                $matches = $this->filterMatches($matches);
                $controllerReturn = $this->callControllerMethod($controller, $callback[1], $matches);

                if ($this->sendControllerResponse($controllerReturn)) {
                    return true;
                }

                if ($this->sendControllerResponse($controller->getResponse())) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Replaces the dynamic parts of a route with a regex pattern. In other words, replaces {id} with (?<id>[^/]+)
     *
     * @param string $pattern
     * @return string
     */
    private function replaceDynamicPartOfRoute(string $pattern): string
    {
        return preg_replace('/{([^}]+)}/', '(?<$1>[^/]+)', $pattern);
    }

    /**
     * Checks if the given uri matches the given pattern.
     *
     * @param string $pattern
     * @param string $uri
     * @return array
     */
    private function routeMatches(string $pattern, string $uri): array
    {
        $matches = [];
        $isMatch = preg_match('#^' . $pattern . '$#', $uri, $matches);
        return [$isMatch, $matches];
    }

    /**
     * Executes the middlewares for the current route.
     *
     * @param array|null $middlewares
     * @return boolean
     */
    private function executeMiddlewares(?array $middlewares): bool
    {
        if ($middlewares !== null) {
            foreach ($middlewares as $middleware) {
                if ($this->executeMiddleware($middleware)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Executes the given middleware.
     *
     * @param array $middleware The fully qualified name of the middleware class. The symbol.
     * @return bool
     */
    private function executeMiddleware(array $middleware): bool
    {
        $middlewareInstance = new $middleware['name']($middleware['parameters']);
        $middlewareResponse = $middlewareInstance->handle();

        if ($middlewareResponse !== null) {
            $this->abort($middlewareResponse);
            return true;
        }

        return false;
    }


    /**
     * Creates a new controller instance and sets the request object.
     *
     * @param array $callback
     * @param Request $request
     * @return Controller
     */
    private function createController(array $callback, Request $request): Controller
    {
        $controller = new $callback[0];
        $controller->setRequest($request);
        return $controller;
    }

    /**
     * Filters the matches array so it only contains the named matches.
     *
     * @param array $matches
     * @return array
     */
    private function filterMatches(array $matches): array
    {
        return array_intersect_key($matches, array_flip(array_filter(array_keys($matches), 'is_string')));
    }

    /**
     * Calls the method on the controller with the given matches.
     *
     * @param Controller $controller
     * @param string $method
     * @param array $matches
     * @return Response|null Could be null if the controller method returns null. It's allowed to return null.
     */
    private function callControllerMethod(Controller $controller, string $method, array $matches): ?Response
    {
        return $controller->$method($matches);
    }

    /**
     * Sends the given response.
     *
     * @param Response $response
     * @return boolean
     */
    private function sendControllerResponse(Response $response): bool
    {
        if ($response !== null) {
            $response->send();
            return true;
        }

        return false;
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
