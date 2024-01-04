<?php

namespace Http\Controllers\Components;

use Lib\MVCCore\Component;
use Lib\MVCCore\Routers\Responses\Response;

class AcceptCookiesComponent implements Component
{
    public function get(?array $data): string
    {
        if (isset($_SESSION['accept-cookies']) && $_SESSION['accept-cookies'] === true) {
            return '';
        }

        return view(VIEWS_PATH . 'Components/AcceptCookies.component.php')->render();
    }
}
