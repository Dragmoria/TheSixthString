<?php

namespace Lib\MVCCore\Routers\Responses;

use Lib\MVCCore\Routers\HTTPStatusCodes;

/**
 * Abstract response class that implements the Response interface. All response can extend this.
 * 
 * @package Lib\MVCCore
 */
abstract class BaseResponse implements Response {
    /**
     * Status code of the response.
     *
     * @var HTTPStatusCodes
     */
    protected HTTPStatusCodes $statusCode = HTTPStatusCodes::OK;
    /**
     * Http headers of the response.
     *
     * @var array
     */
    protected array $headers = [];
    /**
     * Body of the response.
     *
     * @var string
     */
    protected $body = '';
    
    /**
     * Sends the response to the client.
     *
     * @return void
     */
    public function send(): void {
        http_response_code($this->statusCode->value);

        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }

        echo $this->body;
    }

    /**
     * Used to set the status code of the response.
     *
     * @param HTTPStatusCodes $statusCode Status code of the response.
     * @return Response Returns the response so that it can be chained.
     */
    public function setStatusCode(HTTPStatusCodes $statusCode): Response {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Used to add a http header to the response.
     *
     * @param string $name Name of the header.
     * @param string $value Value of the header.
     * @return Response Returns the response so that it can be chained.
     */
    public function addHeader(string $name, string $value): Response {
        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * Used to add multiple http headers to the response.
     *
     * @param array $headers Array of headers to add.
     * @return Response Returns the response so that it can be chained.
     */
    public function addHeaders(array $headers): Response {
        foreach ($headers as $name => $value) {
            $this->addHeader($name, $value);
        }

        return $this;
    }

    public abstract function setBody(mixed $body): Response;
}