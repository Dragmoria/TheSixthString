<?php

use Http\Controllers\CategoryController;
use Http\Controllers\ControlPanel\ManageAccountsController;
use Http\Controllers\ControlPanel\ControlPanelController;
use Http\Controllers\ControlPanel\ManageBrandsController;
use Http\Controllers\ControlPanel\ManageCategoriesController;
use Http\Controllers\ControlPanel\ManageCouponsController;
use Http\Controllers\ControlPanel\ManageProductsController;
use Http\Controllers\ControlPanel\StatisticsController;
use Http\Controllers\HomeController;
use Http\Controllers\LoginController;
use Http\Controllers\RegisterController;
use Http\Controllers\AccountPageController;
use http\Controllers\ForgotPasswordController;
use Http\Controllers\IndexController;
use Http\Middlewares\isLoggedIn;
use Http\Controllers\ProductController;
use Http\Middlewares\SilentAuthentication;
use Lib\Enums\Role;
use Lib\EnvUtility\EnvHandler;
use Lib\MVCCore\Application;
use Lib\MVCCore\Containers\Container;
use Lib\MVCCore\Middleware;
use Service\AddressService;
use Service\BrandService;
use Service\CategoryService;
use Service\CouponService;
use Service\MailService;
use Service\ProductService;
use Service\ResetpasswordService;
use Service\ReviewService;
use Service\UserService;



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

$test = Application::resolve(MailService::class);
$test->test();



$router = Application::getRouter();
//$router->registerStatusView(HTTPStatusCodes::NOT_FOUND, VIEWS_PATH . '/Errors/404.php');

// Add routes below here.

$router->get('/ControlPanel', [ControlPanelController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Analyst]);
$router->get('/ControlPanel/Accounts', [ManageAccountsController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Admin]);
$router->get('/ControlPanel/Statistics', [StatisticsController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Analyst]);
$router->get('/ControlPanel/Accounts/GetUsersTableData', [ManageAccountsController::class, 'getUsersTableData'])->middleware(SilentAuthentication::class, ["role" => Role::Admin]);
$router->patch('/ControlPanel/Accounts/UpdateUser', [ManageAccountsController::class, 'updateUser'])->middleware(SilentAuthentication::class, ["role" => Role::Admin]);
$router->put('/ControlPanel/Accounts/AddUser', [ManageAccountsController::class, 'addUser'])->middleware(SilentAuthentication::class, ["role" => Role::Admin]);
$router->patch('/ControlPanel/Accounts/ResetPassword', [ManageAccountsController::class, 'resetPassword'])->middleware(SilentAuthentication::class, ["role" => Role::Admin]);
$router->get('/Register', [RegisterController::class, 'register']);
$router->get('/Login', [LoginController::class, 'loginPage']);
$router->put('/Account', [LoginController::class, 'validateLogin']);
$router->get('/Account', [AccountPageController::class, 'AccountPage'])->Middleware(isLoggedIn::class);
$router->post('/Account', [AccountPageController::class, 'Logout']);
$router->post('/RegisterValidate', [RegisterController::class, 'saveRegistery']);
$router->get('/wachtwoord-vergeten', [ForgotPasswordController::class, 'ForgotPassword']);
$router->put('/', [RegisterController::class, 'put']);
$router->post('/RegisterSucces', [RegisterController::class, 'post']);
$router->get('/', [IndexController::class, 'show']);
$router->get('/ControlPanel/ManageCoupons', [ManageCouponsController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/ManageCoupons/GetCouponsTableData', [ManageCouponsController::class, 'getCouponsTableData'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->patch('/ControlPanel/ManageCoupons/UpdateCoupon', [ManageCouponsController::class, 'updateCoupon'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->put('/ControlPanel/ManageCoupons/AddNewCoupon', [ManageCouponsController::class, 'addNewCoupon'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/ManageProducts', [ManageProductsController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/ManageBrands', [ManageBrandsController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/ManageBrands/GetBrandsTableData', [ManageBrandsController::class, 'getBrandsTableData'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->patch('/ControlPanel/ManageBrands/UpdateBrand', [ManageBrandsController::class, 'updateBrand'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->put('/ControlPanel/ManageBrands/AddBrand', [ManageBrandsController::class, 'addBrand'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/ManageCategories', [ManageCategoriesController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/ManageCategories/GetCategoriesTableData', [ManageCategoriesController::class, 'getCategoriesTableData'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/', [IndexController::class, 'show']);
$router->get('/Category', [CategoryController::class, 'index']);
$router->get('/Product', [ProductController::class, 'index']);
$router->get('/Product/{id}', [ProductController::class, 'details']);

//$_SESSION["user"] = ["role" => Role::Admin];

// Run the application.
Application::run();
