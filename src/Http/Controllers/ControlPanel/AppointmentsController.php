<?php

namespace Http\Controllers\ControlPanel;

use Lib\Enums\Months;
use Lib\MVCCore\Application;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\JsonResponse;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Service\TryoutScheduleService;

class AppointmentsController extends Controller
{
    public function show(): ?Response
    {
        $response = new ViewResponse();

        $response->setBody(view(VIEWS_PATH . 'ControlPanel/Appointments.view.php', [])->withLayout(CONTROLPANEL_LAYOUT));

        return $response;
    }

    public function getAppointments(): ?Response
    {
        $tryoutScheduleService = Application::resolve(TryoutScheduleService::class);

        $tryoutSchedules = $tryoutScheduleService->getScheduleForMonth(Months::December);

        $events = [];

        foreach ($tryoutSchedules as $tryoutSchedule) {
            $event = [
                "title" => $tryoutSchedule->product->name,
                "start" => $tryoutSchedule->startDate->format('Y-m-d\TH:i:s'),
                "end" => $tryoutSchedule->endDate->format('Y-m-d\TH:i:s'),
                "productNaam" => $tryoutSchedule->product->name,
                "productId" => $tryoutSchedule->product->id
            ];

            array_push($events, $event);
        }

        $response = new JsonResponse();

        $response->setBody($events);

        return $response;
    }
}
