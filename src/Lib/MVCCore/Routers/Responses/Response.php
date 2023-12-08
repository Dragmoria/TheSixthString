<?php

namespace Lib\MVCCore\Routers\Responses;

use Lib\MVCCore\Routers\HTTPStatusCodes;

/**
 * Interface that represents a response. All response types need to implement this.
 * 
 * @package Lib\MVCCore
 */
interface Response {
    /**
     * Used to send the response to the client.
     *
     * @return void
     */
    public function send(): void;

    /**
     * Used to set the response status code.
     *
     * @param HTTPStatusCodes $statusCode Status code of the response.
     * @return Response Returns the response so that it can be chained.
     */
    public function setStatusCode(HTTPStatusCodes $statusCode): Response;

    /**
     * Used to add a http header to the response.
     *
     * @param string $header Header name.
     * @param string $value Header value.
     * @return Response Returns the response so that it can be chained.
     */
    public function addHeader(string $header, string $value): Response;

    /**
     * Used to add multiple http headers to the response.
     *
     * @param array $headers Array of headers. Each header is an array with two elements, the first one is the header name and the second one is the header value.
     * @return Response Returns the response so that it can be chained.
     */
    public function addHeaders(array $headers): Response;

    /**
     * Used to set the body of the response.
     *
     * @param mixed $body Body of the response. Can be of multiple types depending on the response type. Think json for json response, string for text response, etc.
     * @return Response Returns the response so that it can be chained.
     */
    public function setBody(mixed $body): Response;
}