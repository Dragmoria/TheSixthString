<?php

namespace Http\Controllers;

use Lib\MVCCore\Application;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\HTTPStatusCodes;
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

    public function index(): void {
        $response = new ViewResponse();

        $oldValue = $this->currentRequest->getPostObject()->oldBody()['textfield'] ?? null;

        $response->setStatusCode(HTTPStatusCodes::OK)
        ->setBody(view(VIEWS_PATH . 'Index.view.php', [
            'messageOfTheDay' => $this->getMessageOfTheDay(),
            'products' => $this->getProducts(),
            'oldValue' => $oldValue,
            'error' => $_SESSION['error'] ?? null,
            'success' => $_SESSION['success'] ?? null
        ])->withLayout(VIEWS_PATH . 'Layouts/Main.layout.php'))
        ->addHeader('Content-Type', 'text/html');

        $this->currentRequest->getPostObject()->flush();
        unset($_SESSION['error'], $_SESSION['success']);

        $this->setResponse($response);
    }

    public function put(): void {
        unset($_SESSION['error'], $_SESSION['success']);
        // laten we valideren of de post wel alleen uit nummers bestaat want dat willen we schijnbaar.
        $request = $this->currentRequest;
        if (!is_numeric($request->getPostObject()->body()['textfield'])) {
            $request->getPostObject()->flash();
            $_SESSION['error'] = 'The textfield can only contain numbers.';
            redirect('/');
        }
        else {
            $_SESSION['success'] = 'The textfield only contained numbers.';

            // sla de data op in de database of zoiets

            redirect('/');
        }
    }
}