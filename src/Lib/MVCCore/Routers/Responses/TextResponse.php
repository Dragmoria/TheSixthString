<?php

namespace Lib\MVCCore\Routers\Responses;

/**
 * Class that represents a text response.
 * 
 * @package Lib\MVCCore
 */
class TextResponse extends BaseResponse {
    /**
     * Used to set the body of the response. Since this is a text response, the body must be a string. It will also add the content type header to the response.
     *
     * @param string $body
     * @return Response
     */
    public function setBody($body): Response {
        // check if body is string, if not throw exception
        if (!is_string($body)) {
            throw new \InvalidArgumentException('Body must be a string');
        }
        
        // Implement the setBody method
        $this->body = $body;
        $this->addHeader('Content-Type', 'text/plain');
        return $this;
    }
}