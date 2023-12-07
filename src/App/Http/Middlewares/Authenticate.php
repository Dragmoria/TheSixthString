<?php

namespace Http\Middlewares;

use Lib\MVCCore\Middleware;
use Lib\MVCCore\Routers\HTTPStatusCodes;

class Authenticate implements Middleware {
    private array $acceptedRoles;

    public function __construct(array $acceptedRoles) {
        $this->acceptedRoles = $acceptedRoles;
    }

    public function handle(): ?HTTPStatusCodes {
        if (!isset($_SESSION["user"]["role"])) {
            redirect('/Login');
            exit;
        }

        if (!in_array($_SESSION["user"]["role"], $this->acceptedRoles)) {
            redirect('/Login');
            exit;
        }

        return null;
    }
}