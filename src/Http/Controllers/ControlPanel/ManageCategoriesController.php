<?php

namespace Http\Controllers\ControlPanel;

use Lib\MVCCore\Application;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;
use Service\CategoryService;

class ManageCategoriesController extends Controller
{
    public function show(): ?Response
    {
        $response = new ViewResponse();

        $response->setBody(view(VIEWS_PATH . 'ControlPanel/ManageCategories.view.php')->withLayout(CONTROLPANEL_LAYOUT));

        return $response;
    }

    public function getCategoriesTableData(): ?Response
    {
        $categoryService = Application::resolve(CategoryService::class);

        $t = $categoryService->getCategories();

        dumpDie($t);
    }
}
