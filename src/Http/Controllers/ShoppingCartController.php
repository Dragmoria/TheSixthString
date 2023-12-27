<?php

namespace Http\Controllers;

use Lib\MVCCore\Application;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\JsonResponse;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\TextResponse;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Service\ProductService;
use Service\ShoppingCartService;

class ShoppingCartController extends Controller {
    public function index(): ?Response {
        $response = new ViewResponse();

        $data = Application::resolve(ShoppingCartService::class)->getShoppingCartContent(1, "aa03fb5e-fe78-4802-85f9-ad2a4106c349");

        $response->setBody(view(VIEWS_PATH . 'ShoppingCart.view.php', ['data' => $data])->withLayout(MAIN_LAYOUT));

        return $response;
    }

    public function deleteItem(): ?Response {
        $postBody = $this->currentRequest->postObject->body();
        $shoppingCartItemId = $postBody["id"];

        $result = new \stdClass();
        $result->success = Application::resolve(ShoppingCartService::class)->deleteItem(1, "aa03fb5e-fe78-4802-85f9-ad2a4106c349", $shoppingCartItemId);

        $response = new JsonResponse();
        $response->setBody((array)$result);
        return $response;
    }

    public function addItem(): ?Response {
        $postBody = $this->currentRequest->postObject->body();

        $productId = $postBody["productId"];
        $quantity = $postBody["quantity"];

        $response = new JsonResponse();
        $result = new \stdClass();

        $this->validateProductAmountValidAndAvailable($productId, $quantity, $result);
        if($result->success) {
            $result->success = Application::resolve(ShoppingCartService::class)->addItem(1, "aa03fb5e-fe78-4802-85f9-ad2a4106c349", $productId, $quantity);
        }

        $response->setBody((array)$result);

        return $response;
    }

    public function changeQuantity(): ?Response {
        $postBody = $this->currentRequest->postObject->body();

        $productId = $postBody["productId"];
        $quantity = $postBody["quantity"];

        $response = new JsonResponse();
        $result = new \stdClass();

        $this->validateProductAmountValidAndAvailable($productId, $quantity, $result);
        if($result->success) {
            //TODO: zowel id als sessionuserguid ophalen (guid moet nog ergens worden gezet?)
            $result->success = Application::resolve(ShoppingCartService::class)->changeQuantity(1, "aa03fb5e-fe78-4802-85f9-ad2a4106c349", $productId, $quantity);
        }

        $response->setBody((array)$result);
        return $response;
    }

    private function validateProductAmountValidAndAvailable(int $productId, int $quantity, \stdClass &$resultObject): void {
        $resultObject->success = true;

        if($quantity <= 0) {
            $resultObject->success = false;
            $resultObject->message = "Kies een geldig aantal";

            return;
        }

        $amountInStock = Application::resolve(ProductService::class)->getAmountInStockForProduct($productId);

        $isChosenAmountInStock = $amountInStock >= $quantity;
        $resultObject->success = $isChosenAmountInStock;
        $resultObject->message = !$isChosenAmountInStock ? "Gekozen aantal is niet op voorraad, aantal beschikbaar: $amountInStock" : "";
    }
}