<?php

namespace Http\Controllers\ControlPanel;

use Lib\Enums\Role;
use Lib\MVCCore\Application;
use Lib\MVCCore\Component;
use Service\ReviewService;

class SidebarComponent implements Component
{
    public function get(?array $data): string
    {
        $reviewService = Application::resolve(ReviewService::class);

        $amountToBeReviewed = ""; //$reviewService->amountToBeReviewed();


        $currentRole = currentRole();

        $buttons = [
            [
                "path" => "/ControlPanel/Statistics",
                "enabled" => $currentRole->hasRightsOf(Role::Analyst),
                "text" => "Statistieken",
                "notifications" => ""
            ],
            [
                "path" => "/ControlPanel/ManageProducts",
                "enabled" => $currentRole->hasRightsOf(Role::Manager),
                "text" => "Product beheer",
                "notifications" => ""
            ],
            [
                "path" => "/ControlPanel/ManageBrands",
                "enabled" => $currentRole->hasRightsOf(Role::Manager),
                "text" => "Brand beheer",
                "notifications" => ""
            ],
            [
                "path" => "/ControlPanel/ManageCategories",
                "enabled" => $currentRole->hasRightsOf(Role::Manager),
                "text" => "Categorie beheer",
                "notifications" => ""
            ],
            [
                "path" => "/ControlPanel/ManageCoupons",
                "enabled" => $currentRole->hasRightsOf(Role::Manager),
                "text" => "Beheer coupons",
                "notifications" => ""
            ],
            [
                "path" => "/ControlPanel/ModerateReviews",
                "enabled" => $currentRole->hasRightsOf(Role::Manager),
                "text" => "Moderate reviews",
                "notifications" => $amountToBeReviewed
            ],
            [
                "path" => "/ControlPanel/OrderManagement",
                "enabled" => $currentRole->hasRightsOf(Role::Manager),
                "text" => "Beheer orders",
                "notifications" => ""
            ],
            [
                "path" => "/ControlPanel/Accounts",
                "enabled" => $currentRole->hasRightsOf(Role::Admin),
                "text" => "Beheer accounts",
                "notifications" => ""
            ],
            [
                "path" => "/ControlPanel/Appointments",
                "enabled" => $currentRole->hasRightsOf(Role::Manager),
                "text" => "Bekijk afspraken",
                "notifications" => ""
            ],
        ];


        return view(VIEWS_PATH . 'ControlPanel/Sidebar.component.php', [
            "buttons" => $buttons,
            "currentPath" => parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
        ])->render();
    }
}
