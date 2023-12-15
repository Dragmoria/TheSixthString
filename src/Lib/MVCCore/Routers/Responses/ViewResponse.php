<?php

namespace Lib\MVCCore\Routers\Responses;

use Lib\MVCCore\View;

/**
 * Class that represents a view response.
 * 
 * @package Lib\MVCCore
 */
class ViewResponse extends BaseResponse {
    /**
     * Used to set the body of the response. Since this is a view response, the body must be a view. It will also add the content type header to the response.
     *
     * @param View $body
     * @return Response
     */
    public function setBody($body): Response {
        // check if body is view, if not throw exception
        if (!($body instanceof View)) {
            throw new \InvalidArgumentException('Body must be a view');
        }

        // Implement the setBody method
        $this->body = $body->render();
        $this->addHeader('Content-Type', 'text/html');
        return $this;
    }
}