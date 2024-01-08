<?php

use Http\Controllers\AcceptCookiesController;
use Http\Controllers\CategoryController;
use Http\Controllers\HomeController;
use Http\Controllers\LoginController;
use Http\Controllers\RegisterController;
use Http\Controllers\AccountPageController;
use Http\Controllers\Components\AcceptCookiesComponent;
use Http\Controllers\ControlPanel\AppointmentsController;
use Http\Controllers\ContactFormController;
use Http\Controllers\ForgotPasswordController;
use Http\Controllers\IndexController;
use Http\Controllers\ServiceController;
use Http\Controllers\OverigController;
use Http\Controllers\VoorwaardenController;
use Http\Controllers\GarantieController;
use Http\Controllers\DisclaimerController;
use Http\Controllers\PrivacyController;
use Http\Controllers\Mailcontroller;
use Http\Middlewares\isLoggedIn;
use Http\Controllers\ProductController;
use Http\Controllers\ResetPasswordController;
use Http\Controllers\ShoppingCartController;
use Lib\EnvUtility\EnvHandler;
use Lib\MVCCore\Application;
use Lib\MVCCore\Containers\Container;
use Lib\MVCCore\Routers\HTTPStatusCodes;
use Service\ActivateService;
use Service\AddressService;
use Service\BrandService;
use Service\CategoryService;
use Service\CouponService;
use Service\OrderItemService;
use Service\OrderService;
use Service\PaymentService;
use Service\ProductService;
use Service\ResetpasswordService;
use Service\RandomLinkService;
use Service\ReviewService;
use Service\TryoutScheduleService;
use Service\ShoppingCartService;
use Service\UserService;
use Service\VisitedProductService;


Application::initialize();

date_default_timezone_set('Europe/Amsterdam'); // Replace 'Europe/Amsterdam' with your timezone

$container = Container::getInstance();
// Register some services here. Supports singleton and transient services.
$container->registerClass(EnvHandler::class)->asSingleton()->setResolver(function () {
    return new EnvHandler(BASE_PATH . '.env');
});
$container->registerClass(AddressService::class)->asSingleton();
$container->registerClass(ReviewService::class)->asSingleton();
$container->registerClass(CategoryService::class)->asSingleton();
$container->registerClass(UserService::class)->asSingleton();
$container->registerClass(ResetpasswordService::class)->asSingleton();
$container->registerClass(CouponService::class)->asSingleton();
$container->registerClass(ProductService::class)->asSingleton();
$container->registerClass(BrandService::class)->asSingleton();
$container->registerClass(RandomLinkService::class)->asSingleton();
$container->registerClass(ActivateService::class)->asSingleton();
$container->registerClass(OrderService::class)->asSingleton();
$container->registerClass(TryoutScheduleService::class)->asSingleton();
$container->registerClass(ShoppingCartService::class)->asSingleton();
$container->registerClass(OrderItemService::class)->asSingleton();
$container->registerClass(PaymentService::class)->asSingleton();
$container->registerClass(VisitedProductService::class)->asSingleton();

$router = Application::getRouter();
$router->registerStatusView(HTTPStatusCodes::NOT_FOUND, view(VIEWS_PATH . 'StatusViews/404.view.php')->withLayout(MAIN_LAYOUT));
$router->registerStatusView(HTTPStatusCodes::UNAUTHORIZED, view(VIEWS_PATH . 'StatusViews/401.view.php')->withLayout(MAIN_LAYOUT));
$router->registerStatusView(HTTPStatusCodes::FORBIDDEN, view(VIEWS_PATH . 'StatusViews/403.view.php')->withLayout(MAIN_LAYOUT));

// Add routes below here.

require_once BASE_PATH . 'Routes/ControlPanel.php';

$router->get('/Register', [RegisterController::class, 'register']);
$router->post('/RegisterValidate', [RegisterController::class, 'saveRegistery']);
$router->get('/Activate/{dynamicLink}', [RegisterController::class, 'Activate']);
$router->post('/RegisterSucces', [RegisterController::class, 'post']);

$router->get('/Login', [LoginController::class, 'loginPage']);
$router->put('/Account', [LoginController::class, 'validateLogin']);

$router->post('/CreateRandomURL', [ForgotPasswordController::class, 'CreateRandomURL']);
$router->get('/ForgotPassword', [ForgotPasswordController::class, 'ForgotPassword']);

$router->get('/ResetPassword/{dynamicLink}', [ResetPasswordController::class, 'ResetPassword']);
$router->post('/UpdatePassword', [ResetPasswordController::class, 'changePasswords']);

$router->get('/Account', [AccountPageController::class, 'AccountPage'])->Middleware(isLoggedIn::class);
$router->post('/Account', [AccountPageController::class, 'Logout']);
$router->post('/logout', [AccountPageController::class, 'Logout']);
$router->post('/UpdateInfo', [AccountPageController::class, 'updateInfo']);
$router->post('/UpdateUserPassword', [AccountPageController::class, 'updateUserPassword']);
$router->post('/UpdateEmail', [AccountPageController::class, 'updateEmail']);
$router->post('/deleteAccount', [AccountPageController::class, 'deleteAccount']);
$router->get('/AccountDeleted', [AccountPageController::class, 'DeleteFinished']);
$router->post('/RetrievingOrderHistory', [AccountPageController::class, 'RetrievingOrderHistory']);
$router->post('/GetOrderOverview', [AccountPageController::class, 'GetOrderOverview']);
$router->post('/LogOutPulse', [AccountPageController::class, 'LogOutPulse']);

$router->get('/Contact', [ContactFormController::class, 'show']);
$router->post('/ContactForm/Send', [ContactFormController::class, 'send']);

$router->get('/Mail', [MailController::class, 'mail']);

$router->get('/', [IndexController::class, 'show']);
$router->get('/Service', [ServiceController::class, 'show']);
$router->get('/Overig', [OverigController::class, 'show']);
$router->get('/AlgemeneVoorwaarden', [VoorwaardenController::class, 'show']);
$router->get('/Garantie', [GarantieController::class, 'show']);
$router->get('/Disclaimer', [DisclaimerController::class, 'show']);
$router->get('/Privacy', [PrivacyController::class, 'show']);
$router->get('/Category', [CategoryController::class, 'index']);
$router->get('/Category/{id}', [CategoryController::class, 'index']);
$router->get('/Product', [ProductController::class, 'index']);
$router->get('/Product/{id}', [ProductController::class, 'details']);
$router->post('/Product/GetSuggestedProducts', [ProductController::class, 'getSuggestedProducts']);
$router->post('/Product/CreateReview', [ProductController::class, 'createReview']);
$router->get('/Appointments/GetNotAvailableTimeSlots', [AppointmentsController::class, 'getNotAvailableTimeSlots']);
$router->post('/Appointments/SetNewAppointment', [AppointmentsController::class, 'setNewAppointment'])->middleware(isLoggedIn::class);

$router->get('/ShoppingCart', [ShoppingCartController::class, 'index']);
$router->get('/ShoppingCart/PersonalInformation', [ShoppingCartController::class, 'personalInformationView'])->middleware(isLoggedIn::class);
$router->get('/ShoppingCart/Payment', [ShoppingCartController::class, 'paymentView'])->middleware(isLoggedIn::class);
$router->post('/ShoppingCart/DeleteItem', [ShoppingCartController::class, 'deleteItem']);
$router->post('/ShoppingCart/AddItem', [ShoppingCartController::class, 'addItem']);
$router->post('/ShoppingCart/ChangeQuantity', [ShoppingCartController::class, 'changeQuantity']);
$router->post('/ShoppingCart/ProcessCoupon', [ShoppingCartController::class, 'processCoupon']);
$router->post('/ShoppingCart/RemoveCoupon', [ShoppingCartController::class, 'removeCoupon']);

$router->post('/ShoppingCart/StartPayment', [ShoppingCartController::class, 'startPayment'])->middleware(isLoggedIn::class);
$router->get('/ShoppingCart/FinishPayment', [ShoppingCartController::class, 'finishPayment'])->middleware(isLoggedIn::class);
$router->get('/ShoppingCart/DoPayment/{orderid}', [ShoppingCartController::class, 'doPayment'])->middleware(isLoggedIn::class);
$router->get('/ShoppingCart/PaymentFinished', [ShoppingCartController::class, 'doPayment'])->middleware(isLoggedIn::class);

$router->post('/accept-cookies', [AcceptCookiesController::class, 'acceptCookies']);

// unset($_SESSION['accept-cookies']);

if (!isset($_SESSION["sessionUserGuid"])) {
    $_SESSION["sessionUserGuid"] = getGUID();
}

// Run the application.
Application::run();
