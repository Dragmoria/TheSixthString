<?php

namespace Http\Controllers\ControlPanel;

use Lib\Enums\Role;
use Lib\MVCCore\Component;

class SidebarComponent implements Component
{
    public function get(?array $data): string
    {
        $currentRole = currentRole();

        $buttons = [
            [
                "path" => "/ControlPanel/Statistics",
                "enabled" => $currentRole->hasRightsOf(Role::Analyst),
                "text" => "Statistieken",
                "notifications" => ""
            ],
            [
                "path" => "/ControlPanel/ManageContent",
                "enabled" => $currentRole->hasRightsOf(Role::Analyst),
                "text" => "Content beheer",
                "notifications" => ""
            ],
            [
                "path" => "/ControlPanel/ManageVouchers",
                "enabled" => $currentRole->hasRightsOf(Role::Analyst),
                "text" => "Beheer vouchers",
                "notifications" => ""
            ],
            [
                "path" => "/ControlPanel/ModerateReviews",
                "enabled" => $currentRole->hasRightsOf(Role::Analyst),
                "text" => "Moderate reviews",
                "notifications" => ""
            ],
            [
                "path" => "/ControlPanel/OrderManagement",
                "enabled" => $currentRole->hasRightsOf(Role::Analyst),
                "text" => "Beheer orders",
                "notifications" => ""
            ],
            [
                "path" => "/ControlPanel/Accounts",
                "enabled" => $currentRole->hasRightsOf(Role::Analyst),
                "text" => "Beheer accounts",
                "notifications" => ""
            ],
        ];


        return view(VIEWS_PATH . 'ControlPanel/Sidebar.component.php', [
            "buttons" => $buttons,
            "currentPath" => parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
        ])->render();
    }
}
