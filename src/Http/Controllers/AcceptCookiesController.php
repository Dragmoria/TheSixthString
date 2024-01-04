<?php

namespace Http\Controllers;

use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\JsonResponse;
use Lib\MVCCore\Routers\Responses\Response;

class AcceptCookiesController extends Controller
{
    public function acceptCookies(): ?Response
    {
        $postBody = $this->currentRequest->postObject->body();

        $response = new JsonResponse();

        if (!isset($postBody['accept'])) {
            $response->setBody([
                'success' => false,
                'error' => 'No accept-cookies field in the request body.'
            ]);

            return $response;
        }

        $_SESSION['accept-cookies'] = true;

        $response->setBody([
            'success' => true
        ]);

        return $response;
    }
}
