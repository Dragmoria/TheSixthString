<?php

namespace Http\Controllers\Components;

use Lib\MVCCore\Component;

class NavbarComponent implements Component
{
    public function get(?array $data): string
    {
        $currentPath = $_SERVER['REQUEST_URI'];

        return view(VIEWS_PATH . 'Components/Navbar.component.php', [
            'currentPath' => $currentPath
        ])->render();
    }
}
