<?php

namespace Http\Controllers;

use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;

class HomeController extends Controller
{
    public function index(): ?Response
    {
        $response = new ViewResponse();


        $request = $this->currentRequest;


        $response->setBody(view(VIEWS_PATH . 'Index.view.php', [
            'title' => "Home",
            'countSomething' => 1,
            'someArray' => [
                'key' => 'Henk'
            ],
            'errors' => $request->postObject->getPostErrors() ?? [],
            'old' => $request->postObject->old(),
        ])->withLayout(VIEWS_PATH . 'Layouts/Main.layout.php'));

        $request->postObject->flush();

        return $response;
    }


    public function postExample()
    {
        $request = $this->currentRequest;
        $postBody = $request->postObject->body();

        // save to db

        // check if age een nummer is

        if (!is_numeric($postBody['age'])) {
            $request->postObject->flash();
            $request->postObject->flashPostError('age', 'Age must be a number');
            redirect('/');
        }


        redirect('/');
    }
}
