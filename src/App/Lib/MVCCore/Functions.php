<?php

use Lib\MVCCore\View;

/**
 * Globally available factory function to create a view.
 *
 * @param string $view Path to the view file.
 * @param array $data Array of data to extract into the view's scope.
 * @return View Returns a view object.
 */
function view(string $view, array $data = []): View {
    $viewPath = $view;

    return new View($viewPath, $data);
};

/**
 * Globally available functio that renders a component. Can be used inside a view to import a component with it's own controller.
 *
 * @param string $componentName Fully qualified name of the component class to use.
 * @return string Returns the output of the component as a string. Will be the html coming from the component's get method.
 */
function component(string $componentName): string {
    $component = new $componentName();

    return $component->get();
}

/**
 * Globally available function that redirects the client to the given url.
 *
 * @param string $url The url to redirect to.
 * @return void
 */
function redirect(string $url): void {
    header("Location: $url");
    exit;
}