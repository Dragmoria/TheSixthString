<?php

namespace Http\Middlewares;

use Lib\Enums\Role;
use Lib\MVCCore\Middleware;
use Lib\MVCCore\Routers\HTTPStatusCodes;

class isLoggedIn implements Middleware {
    public function handle(){
    if (!isset($_SESSION["user"]["id"])) {
        redirect('/Login');
    } else {
        return null;
    }
    }
}