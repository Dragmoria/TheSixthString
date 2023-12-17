<?php

namespace Http\Controllers;

use Lib\MVCCore\Controller;

class TestSomethingController extends Controller
{
    public function test($id, $name)
    {
        dump("test");
        dumpDie($id, $name);
    }

    public function test2($id, $name)
    {
        dump("test2");
        dumpDie($id, $name);
    }
}
