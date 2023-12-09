<?php

namespace Lib\MVCCore;

use Lib\MVCCore\Routers\HTTPStatusCodes;
use Lib\MVCCore\Routers\Responses\Response;

/**
 * Ensures that all middleware classes have a handle method.
 * 
 * @package Lib\MVCCore
 */
interface Middleware {
    /**
     * Method that will be called by the router to handle the request.
     *
     * @return HTTPStatusCodes|null Returns a HTTPStatusCodes if the middleware wants to return a HTTPStatusCodes. Returns null if the middleware wants to continue to the next middleware.
     */
    public function handle(): ?HTTPStatusCodes;
}