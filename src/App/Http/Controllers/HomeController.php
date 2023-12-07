<?php

namespace Http\Controllers;

use Lib\MVCCore\Application;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\HTTPStatusCodes;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Models\DailyMessageModel;
use Models\ProductsModel;

class HomeController extends Controller {
    private function getMessageOfTheDay(): string {
        $messageOfTheDay = Application::resolve(DailyMessageModel::class)->getMessage();
        return $messageOfTheDay;
    }

    private function getProducts(): array {
        $products = Application::resolve(ProductsModel::class)->getProducts();
        return $products;
    }

    public function index(): ?Response {
        $response = new ViewResponse();

        $postObject = $this->currentRequest->getPostObject();
        $oldValue = $postObject->oldBody()['textfield'] ?? null;

        $response->setStatusCode(HTTPStatusCodes::OK)
        ->setBody(view(VIEWS_PATH . 'Index.view.php', [
            'messageOfTheDay' => $this->getMessageOfTheDay(),
            'products' => $this->getProducts(),
            'oldValue' => $oldValue,
            'error' => $postObject->getPostError('textfield'),
            'success' => $postObject->getPostSuccess('textfield')
        ])->withLayout(VIEWS_PATH . 'Layouts/Main.layout.php'))
        ->addHeader('Content-Type', 'text/html');

        $postObject->flush();
        unset($_SESSION['error'], $_SESSION['success']);

        return $response;
    }

    public function put(): void {
        unset($_SESSION['error'], $_SESSION['success']);
        $postObject = $this->currentRequest->getPostObject();

        if (!is_numeric($postObject->body()['textfield'])) {
            $postObject->flash();
            $postObject->flashPostError('textfield', 'The textfield can only contain numbers.');
            redirect('/');
        }
        else {
            $postObject->flashPostSuccess('textfield', 'The textfield only contained numbers.');

            // sla de data op in de database of zoiets

            redirect('/');
        }
    }
}