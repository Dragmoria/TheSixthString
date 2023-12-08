<?php

namespace Http\Controllers;

use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;

class ProductsController extends Controller {
    public function show($id): ?Response {
        dumpDie($id);

        return null;
    }
}