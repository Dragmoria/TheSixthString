<?php
// Entrace point of the application set up through the .htaccess file in the public folder so the client can't access the other files.

// Adds a global constant for the base path of the application.
const BASE_PATH = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;
// Adds a global constant for the path to the Content folder to use when you want to load a view.
const VIEWS_PATH = BASE_PATH . 'Content' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR;
// Adds a global constant for the path to the Runtime folder to use when you want to cache something.
const RUNTIME_PATH = BASE_PATH . 'Runtime' . DIRECTORY_SEPARATOR;
// Add a global constant for the namespace of the components to use when adding a component to a view.
const COMPONENT_NAMESPACE = 'HTTP\\Controllers\\Components\\';

const MAIL_TEMPLATES = BASE_PATH . 'EmailTemplates' . DIRECTORY_SEPARATOR;

const MAIN_LAYOUT = BASE_PATH . 'Content' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'Layouts' . DIRECTORY_SEPARATOR . 'Main.layout.php';
const CONTROLPANEL_LAYOUT = BASE_PATH . 'Content' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'Layouts' . DIRECTORY_SEPARATOR . 'ControlPanel.layout.php';

// Register the autoloader so you don't have to manually require files anymore.
spl_autoload_register(function ($class) {
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);

    require_once BASE_PATH . $path . '.php';
});

// Require the helper functions file so we can use these functions anywhere in the application.
require_once BASE_PATH . '/Lib/MVCCore/Functions.php';
require_once BASE_PATH . '/Helperfunctions.php';

// Require the bootstrap file so we can initialize the application and run it.
require_once BASE_PATH . 'bootstrapper.php';
