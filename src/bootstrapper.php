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
use Http\Controllers\ControlPanel\AppointmentsController;
use http\Controllers\ForgotPasswordController;
use Http\Controllers\IndexController;
use Http\Controllers\Mailcontroller;
use Http\Middlewares\isLoggedIn;
use Http\Controllers\ProductController;
use Http\Controllers\ResetPasswordController;
use Http\Controllers\ShoppingCartController;
use Http\Middlewares\SilentAuthentication;
use Lib\Enums\Role;
use Lib\EnvUtility\EnvHandler;
use Lib\MVCCore\Application;
use Lib\MVCCore\Containers\Container;
use Lib\MVCCore\Middleware;
use Service\ActivateService;
use Service\AddressService;
use Service\BrandService;
use Service\CategoryService;
use Service\CouponService;
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

$router = Application::getRouter();
//$router->registerStatusView(HTTPStatusCodes::NOT_FOUND, VIEWS_PATH . '/Errors/404.php');

// Add routes below here.

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


$router->get('/ControlPanel', [ControlPanelController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Analyst]);
$router->get('/ControlPanel/Accounts', [ManageAccountsController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Admin]);
$router->get('/ControlPanel/Accounts/GetUsersTableData', [ManageAccountsController::class, 'getUsersTableData'])->middleware(SilentAuthentication::class, ["role" => Role::Admin]);
$router->patch('/ControlPanel/Accounts/UpdateUser', [ManageAccountsController::class, 'updateUser'])->middleware(SilentAuthentication::class, ["role" => Role::Admin]);
$router->put('/ControlPanel/Accounts/AddUser', [ManageAccountsController::class, 'addUser'])->middleware(SilentAuthentication::class, ["role" => Role::Admin]);
$router->patch('/ControlPanel/Accounts/ResetPassword', [ManageAccountsController::class, 'resetPassword'])->middleware(SilentAuthentication::class, ["role" => Role::Admin]);
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
$router->get('/ControlPanel/Statistics', [StatisticsController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Analyst]);


$router->get('/ControlPanel/Appointments', [AppointmentsController::class, 'show'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/ControlPanel/Appointments/GetAppointments', [AppointmentsController::class, 'getAppointments'])->middleware(SilentAuthentication::class, ["role" => Role::Manager]);
$router->get('/Mail', [MailController::class, 'mail']);
$router->get('/ResetPassword/{dynamicLink}', [ResetPasswordController::class, 'ResetPassword']);
$router->post('/CreateRandomURL', [ForgotPasswordController::class, 'CreateRandomURL']);
$router->post('/UpdatePassword', [ResetPasswordController::class, 'changePasswords']);
$router->get('/Activate/{dynamicLink}', [RegisterController::class, 'Activate']);


$router->get('/ShoppingCart', [ShoppingCartController::class, 'index']);
$router->post('/ShoppingCart/DeleteItem', [ShoppingCartController::class, 'deleteItem']);
$router->post('/ShoppingCart/AddItem', [ShoppingCartController::class, 'addItem']);
$router->post('/ShoppingCart/ChangeQuantity', [ShoppingCartController::class, 'changeQuantity']);

$_SESSION["user"] = ["role" => Role::Admin];
$_SESSION["user"]["id"] = 1;
$_SESSION["sessionUserGuid"] = "aa03fb5e-fe78-4802-85f9-ad2a4106c349"; //TODO: deze moet worden gezet als deze nog niet in de sessie staat, bij elke request checken in middleware?

// Run the application.
Application::run();
