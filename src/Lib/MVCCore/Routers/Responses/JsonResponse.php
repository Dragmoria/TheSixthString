<?php

namespace Lib\MVCCore\Routers\Responses;

/**
 * Class that represents a JSON response.
 * 
 * @package Lib\MVCCore
 */
class JsonResponse extends BaseResponse {
    /**
     * Used to set the body of the response. Since this is a JSON response, the body must be a JSON object. It will also add the content type header to the response.
     *
     * @param array $body
     * @return Response
     */
    public function setBody($body): Response {
        // check if body is array, if not throw exception
        if (!is_array($body)) {
            throw new \InvalidArgumentException('Body must be an array');
        }

        // Implement the setBody method
        $this->body = json_encode($body);
        $this->addHeader('Content-Type', 'application/json');
        return $this;
    }
}