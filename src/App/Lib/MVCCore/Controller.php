<?php

namespace Lib\MVCCore;

use Lib\MVCCore\Routers\HTTPStatusCodes;
use Lib\MVCCore\Routers\Request;
use Lib\MVCCore\Routers\Responses\Response;

/**
 * Abstract Controller class that all controllers should extend. It contains some helper methods to make it easier to work with the request and response.
 * 
 * @package Lib\MVCCore
 */
abstract class Controller {
    /**
     * Will hold the current request object.
     *
     * @var Request
     */
    protected Request $currentRequest;
    /**
     * Will hold the current response object.
     *
     * @var Response
     */
    protected Response $currentResponse;

    /**
     * Used to set the current response object. This is required by the router to send the response to the client. Can be set manually as well.
     *
     * @param Response $response The response object to set.
     * @return void
     */
    protected function setResponse(Response $response): void {
        $this->currentResponse = $response;
    }

    /**
     * Used to set the current request object so controllers can have easy access to the request data.
     *
     * @param Request $request The request object to set.
     * @return void
     */
    public function setRequest(Request $request): void {
        $this->currentRequest = $request;
    }
    
    /**
     * Used to redirect the client to the given url with a specific status code. If no status code is given, it will default to 200.
     *
     * @param string $url The url to redirect to.
     * @param HTTPStatusCode $statusCode The status code to use for the redirect.
     * @return void
     */
    protected function redirect(string $url, HTTPStatusCodes $statusCode = HTTPStatusCodes::OK): void {
        $currentResponse = new Response();
        $currentResponse->addHeader('Location', $url)->setStatusCode($statusCode);
    }

    /**
     * Used by the router to get the current response object so it can be sent to the client. This is why setting the current response object is required.
     *
     * @return Response|null
     */
    public function getResponse(): ?Response {
        return $this->currentResponse ?? null;
    }
}