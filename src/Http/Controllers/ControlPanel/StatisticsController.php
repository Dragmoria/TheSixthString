<?php

namespace Http\Controllers\ControlPanel;

use Lib\MVCCore\Application;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Service\VisitedProductService;

class StatisticsController extends Controller
{
    public function show(): ?Response
    {
        $response = new ViewResponse();

        $request = $this->currentRequest;
        $urlQueryParams = $request->urlQueryParams();

        $minDate = $urlQueryParams["min-date"] ?? date('Y-m-01');
        $maxDate = $urlQueryParams["max-date"] ?? date('Y-m-t');

        $data = Application::resolve(VisitedProductService::class)->getProductsWithVisitorsForDateRange($minDate, $maxDate);

        $response->setBody(view(VIEWS_PATH . 'ControlPanel/Statistics.view.php', [
            'minDate' => $minDate,
            'maxDate' => $maxDate,
            'data' => $data
        ])->withLayout(CONTROLPANEL_LAYOUT));

        return $response;
    }
}
