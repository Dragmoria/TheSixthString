<?php

namespace Lib\MVCCore\Routers;

/**
 * Enum of request types.
 * 
 * @package Lib\MVCCore
 */
enum RequestTypes: string {
    case GET = "GET";
    case POST = "POST";	
    case PUT = "PUT";
    case DELETE = "DELETE";
    case PATCH = "PATCH";
}