<?php

use Http\Controllers\CategoryController;
use Http\Controllers\HomeController;
use Http\Controllers\LoginController;
use Http\Controllers\RegisterController;
use Http\Controllers\AccountPageController;
use http\Controllers\ForgotPasswordController;
use Http\Controllers\IndexController;
use Http\Controllers\Mailcontroller;
use Http\Middlewares\isLoggedIn;
use Http\Controllers\ProductController;
use Http\Controllers\ResetPasswordController;
use Http\Controllers\ShoppingCartController;
use Lib\EnvUtility\EnvHandler;
use Lib\MVCCore\Application;
use Lib\MVCCore\Containers\Container;
use Service\ActivateService;
use Service\AddressService;
use Service\BrandService;
use Service\CategoryService;
use Service\CouponService;
use Service\OrderService;
use Service\ProductService;
use Service\ResetpasswordService;
use Service\RandomLinkService;
use Service\ReviewService;
use Service\TryoutScheduleService;
use Service\ShoppingCartService;
use Service\UserService;
use Service\MailService;



Application::initialize();

date_default_timezone_set('Europe/Amsterdam'); // Replace 'Europe/Amsterdam' with your timezone

$container = Container::getInstance();
// Register some services here. Supports singleton and transient services.
$container->registerClass(EnvHandler::class)->asSingleton()->setResolver(function () {
    return new EnvHandler(BASE_PATH . '/.env');
});
$container->registerClass(AddressService::class)->asSingleton();
$container->registerClass(ReviewService::class)->asSingleton();
$container->registerClass(CategoryService::class)->asSingleton();
$container->registerClass(UserService::class)->asSingleton();
$container->registerClass(ResetpasswordService::class)->asSingleton();
$container->registerClass(CouponService::class)->asSingleton();
$container->registerClass(ProductService::class)->asSingleton();
$container->registerClass(BrandService::class)->asSingleton();
$container->registerClass(MailService::class);
$container->registerClass(RandomLinkService::class);
$container->registerClass(ActivateService::class);
$container->registerClass(TryoutScheduleService::class)->asSingleton();
$container->registerClass(ShoppingCartService::class)->asSingleton();
$container->registerClass(OrderService::class)->asSingleton();

$router = Application::getRouter();
//$router->registerStatusView(HTTPStatusCodes::NOT_FOUND, VIEWS_PATH . '/Errors/404.php');

// Add routes below here.

require_once BASE_PATH . 'Routes/ControlPanel.php';

$router->get('/Register', [RegisterController::class, 'register']);
$router->get('/Login', [LoginController::class, 'loginPage']);
$router->put('/Account', [LoginController::class, 'validateLogin']);
$router->get('/Account', [AccountPageController::class, 'AccountPage'])->Middleware(isLoggedIn::class);
$router->post('/Account', [AccountPageController::class, 'Logout']);
$router->post('/LogOut', [AccountPageController::class, 'Logout']);
$router->post('/UpdateInfo', [AccountPageController::class, 'updateInfo']);
$router->post('/UpdatePasswordAndEmail', [AccountPageController::class, 'updatePasswordAndEmail']);
$router->post('/RegisterValidate', [RegisterController::class, 'saveRegistery']);
$router->get('/ForgotPassword', [ForgotPasswordController::class, 'ForgotPassword']);
$router->put('/', [RegisterController::class, 'put']);
$router->post('/RegisterSucces', [RegisterController::class, 'post']);
$router->get('/', [IndexController::class, 'show']);
$router->get('/', [IndexController::class, 'show']);
$router->get('/Category', [CategoryController::class, 'index']);
$router->get('/Category/{id}', [CategoryController::class, 'index']);
$router->get('/Product', [ProductController::class, 'index']);
$router->get('/Product/{id}', [ProductController::class, 'details']);
$router->get('/Mail', [MailController::class, 'mail']);

$router->get('/Mail', [MailController::class, 'mail']);
$router->get('/ResetPassword/{dynamicLink}', [ResetPasswordController::class, 'ResetPassword']);
$router->post('/CreateRandomURL', [ForgotPasswordController::class, 'CreateRandomURL']);
$router->post('/UpdatePassword', [ResetPasswordController::class, 'changePasswords']);
$router->get('/Activate/{dynamicLink}', [RegisterController::class, 'Activate']);


$router->get('/ShoppingCart', [ShoppingCartController::class, 'index']);
$router->post('/ShoppingCart/DeleteItem', [ShoppingCartController::class, 'deleteItem']);
$router->post('/ShoppingCart/AddItem', [ShoppingCartController::class, 'addItem']);
$router->post('/ShoppingCart/ChangeQuantity', [ShoppingCartController::class, 'changeQuantity']);

$router->post('/ShoppingCart/StartPayment', [ShoppingCartController::class, 'startPayment'])->middleware(isLoggedIn::class);

if(!isset($_SESSION["sessionUserGuid"])) {
    $_SESSION["sessionUserGuid"] = getGUID();
}

// Run the application.
Application::run();
