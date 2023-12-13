<?php

namespace Http\Middlewares;

use Lib\Enums\Role;
use Lib\MVCCore\Middleware;
use Lib\MVCCore\Routers\HTTPStatusCodes;

class AuthMiddleware implements Middleware
{
    private Role $acceptedRole;

    public function __construct(array $acceptedRoles)
    {
        $this->acceptedRole = $acceptedRoles['role'];
    }

    public function handle(): ?HTTPStatusCodes
    {
        if (!isset($_SESSION['user'])) {
            redirect('/');
        }

        $role = $_SESSION['user']['role']; // 3

        if (!$role->hasRightsOf($this->acceptedRole)) {
            redirect('/');
        }

        return null;
    }
}
