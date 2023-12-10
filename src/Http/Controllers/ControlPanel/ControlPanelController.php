<?php

namespace Http\Controllers\ControlPanel;

use Lib\Enums\Role;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;

class ControlPanelController extends Controller {
    public function show(): ?Response {
        $response = new ViewResponse();

        $currentRole = currentRole();

        $pageButtons = [
            [
                "path" => "/ControlPanel/Statistics",
                "enabled" => $currentRole->hasRightsOf(Role::Analyst),
                "text" => "Statistieken",
                "icon" => "query_stats"
            ],
            [
                "path" => "/ControlPanel/ManageContent",
                "enabled" => $currentRole->hasRightsOf(Role::Manager),
                "text" => "Beheer content",
                "icon" => "file_copy"
            ],
            [
                "path" => "/ControlPanel/ManageVouchers",
                "enabled" => $currentRole->hasRightsOf(Role::Manager),
                "text" => "Beheer vouchers",
                "icon" => "redeem"
            ],
            [
                "path" => "/ControlPanel/ModerateReviews",
                "enabled" => $currentRole->hasRightsOf(Role::Manager),
                "text" => "Moderate reviews",
                "icon" => "star"
            ],
            [
                "path" => "/ControlPanel/OrderManagement",
                "enabled" => $currentRole->hasRightsOf(Role::Manager),
                "text" => "Order beheer",
                "icon" => "orders"
            ],
            [
                "path" => "/ControlPanel/Accounts",
                "enabled" => $currentRole->hasRightsOf(Role::Admin),
                "text" => "Beheer accounts",
                "icon" => "group_add"
            ],
        ];

        $response->setBody(view(VIEWS_PATH . 'ControlPanel/ControlPanel.view.php', [
            "pageButtons" => $pageButtons,
            "currentRole" => $currentRole->toString()
        ])->withLayout(MAIN_LAYOUT));

        return $response;
    }
}