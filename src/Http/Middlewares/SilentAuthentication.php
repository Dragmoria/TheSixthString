<?php

namespace Http\Middlewares;

use Lib\Enums\Role;
use Lib\MVCCore\Middleware;
use Lib\MVCCore\Routers\HTTPStatusCodes;

class SilentAuthentication implements Middleware
{
    private Role $acceptedRole;

    public function __construct(array $acceptedRole)
    {
        $this->acceptedRole = $acceptedRole["role"];
    }

    public function handle(): ?HTTPStatusCodes
    {
        if (!isset($_SESSION["user"]["role"])) {
            return HTTPStatusCodes::NOT_FOUND;
        }

        if (!currentRole()->hasRightsOf($this->acceptedRole)) {
            return HTTPStatusCodes::NOT_FOUND;
        }

        return null;
    }
}
