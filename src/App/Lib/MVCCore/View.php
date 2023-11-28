<?php

namespace Lib\MVCCore;

/**
 * Class View is used to create a view. The router will use it to render the view to the client.
 * 
 * @package Lib\MVCCore
 */
class View {
    /**
     * Path to the view file.
     *
     * @var string
     */
    private string $viewPath;
    /**
     * Array of data to extract into the view's scope.
     *
     * @var array
     */
    private array $data;
    /**
     * Path to a layout file. If set, the view will be rendered inside the layout. If not the view will be rendered on its own.
     *
     * @var string|null
     */
    private ?string $layoutPath;

    /**
     * Constructor of the View class.
     *
     * @param string $viewPath Path to the view file.
     * @param array $data Array of data to extract into the view's scope.
     */
    public function __construct(string $viewPath, array $data = []) {
        $this->viewPath = $viewPath;
        $this->data = $data;
    }

    /**
     * Sets the layout path so the view will be rendered inside the layout.
     *
     * @param string $layoutPath Path to the layout file.
     * @return View Returns the view so you can chain methods.
     */
    public function withLayout(string $layoutPath): View {
        $this->layoutPath = $layoutPath;
        return $this;
    }

    /**
     * Will render the view and return the output as a string so the router can send it to the client.
     *
     * @param string|null $layoutPath Second way to set the layout path. If set, the view will be rendered inside the layout. If not the view will be rendered on its own.
     * @return string Returns the output of the view as a string. Will be the html coming from the view file.
     */
    public function render(string $layoutPath = null): string {
        // Extract the data into the local scope
        extract($this->data);

        // Start output buffering
        ob_start();

        // Include the view file
        include $this->viewPath;

        // Get the contents of the output buffer
        $output = ob_get_clean();

        // If a layout path is set, render the view inside the layout.
        if(isset($this->layoutPath)) {
            $layoutBuffer = view($this->layoutPath, ['content' => $output]);
            return $layoutBuffer->render();
        }

        // Return the output in case no layout is set.
        return $output;
    }
}