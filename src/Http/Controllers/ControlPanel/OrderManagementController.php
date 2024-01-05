<?php

namespace Http\Controllers\ControlPanel;

use Lib\Enums\MolliePaymentStatus;
use Lib\Enums\ShippingStatus;
use Lib\Enums\SortOrder;
use Lib\MVCCore\Application;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\JsonResponse;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Service\OrderService;

class OrderManagementController extends Controller
{
    public function show(): ?Response
    {
        $response = new ViewResponse();

        $response->setBody(view(VIEWS_PATH . 'ControlPanel/OrderManagement.view.php', [])->withLayout(CONTROLPANEL_LAYOUT));

        return $response;
    }

    public function getOrdersTableData(): ?Response
    {
        $params = $this->currentRequest->urlQueryParams();
        $offset = $params['offset'];
        $limit = $params['limit'];
        $sort = $params['sort'];
        $order = SortOrder::from($params['order'] == "" ? "asc" : $params['order']);

        $orderService = Application::resolve(OrderService::class);

        $orders = $orderService->getOrders($sort, $order);

        if ($orders === null) {
            $response = new JsonResponse();
            $response->setBody([
                "total" => 0,
                "rows" => []
            ]);
            return $response;
        }

        $ordersJson = [];
        foreach ($orders as $order) {
            $orderJson = (array) $order;
            $orderJson['createdOn'] = $order->createdOn->format('d-m-Y');
            $orderJson['paymentStatus'] = $order->paymentStatus->toString();
            $orderJson['shippingStatus'] = $order->shippingStatus->toString();

            $ordersJson[] = $orderJson;
        }

        $ordersJson = array_slice($ordersJson, $offset, $limit);

        $response = new JsonResponse();

        $response->setBody([
            "total" => count($orders),
            "rows" => $ordersJson
        ]);

        return $response;
    }

    public function getOrderDetails($params): ?Response
    {
        $orderService = Application::resolve(OrderService::class);


        $order = $orderService->getManagementOrderById($params['orderid']);

        $response = new ViewResponse();

        $response->setBody(view(VIEWS_PATH . 'ControlPanel/OrderDetails.view.php', [
            'order' => $order
        ])->withLayout(CONTROLPANEL_LAYOUT));

        return $response;
    }

    public function setShippingStatus($data): ?Response
    {
        $postBody = $this->currentRequest->postObject->body();

        $setToSent = ShippingStatus::from((int) $postBody['setToSent']);

        $orderService = Application::resolve(OrderService::class);

        $orderService->setShippingStatus($data['orderid'], $setToSent);

        $response = new JsonResponse();

        $response->setBody([
            "success" => true
        ]);

        return $response;
    }
}
