<?php

namespace Http\Controllers;

use Lib\MVCCore\Controller;

class JeMoederController extends Controller
{

    public function test(string $data)
    {
        dumpDie($data);
    }
}
