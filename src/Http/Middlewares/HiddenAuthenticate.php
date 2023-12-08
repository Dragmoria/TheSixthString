<?php

namespace Http\Middlewares;

use Lib\MVCCore\Middleware;
use Lib\MVCCore\Routers\HTTPStatusCodes;

class HiddenAuthenticate implements Middleware {
    private array $acceptedRoles;

    public function __construct(array $acceptedRoles) {
        $this->acceptedRoles = $acceptedRoles;
    }

    public function handle(): ?HTTPStatusCodes {
        if (!isset($_SESSION["user"]["role"])) {
            return HTTPStatusCodes::NOT_FOUND;
        }

        if (!in_array($_SESSION["user"]["role"], $this->acceptedRoles)) {
            return HTTPStatusCodes::NOT_FOUND;
        }

        return null;
    }
}