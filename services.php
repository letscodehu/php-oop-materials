<?php

use Middleware\AuthorizationMiddleware;
use Services\ForgotPasswordService;

return [
    "responseFactory" => function (ServiceContainer $container) {
        return new ResponseFactory($container->get("viewRenderer"));
    },
    "viewRenderer" => function (ServiceContainer $container) {
        return new ViewRenderer($container->get("basePath"));
    },
    'responseEmitter' => function () {
        return new ResponseEmitter();
    },
    'homeController' => function (ServiceContainer $container) {
        return new Controllers\HomeController($container->get("photoService"));
    },
    "config" => function (ServiceContainer $container) {
        $base = $container->get("basePath");
        return include_once $base . "/config.php";
    },
    "connection" => function (ServiceContainer $container) {
        $config = $container->get("config");
        $connection = mysqli_connect($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
        if (!$connection) {
            throw new SqlException('Connection error: ' . mysqli_error($connection));
        }
        return $connection;
    },
    "baseUrl" => function() {
        $protocol = strpos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
        return $protocol.$_SERVER['HTTP_HOST'];
    },
    "photoService" => function (ServiceContainer $container) {
        return new Services\PhotoService($container->get("connection"));
    },
    'singleImageController' => function (ServiceContainer $container) {
        return new Controllers\SingleImageController($container->get("photoService"));
    },
    'singleImageEditController' => function () {
        return new Controllers\SingleImageEditController();
    },
    'singleImageDeleteController' => function () {
        return new Controllers\SingleImageDeleteController();
    },
    'loginFormController' => function (ServiceContainer $container) {
        return new Controllers\LoginFormController($container->get("session"));
    },
    'loginSubmitController' => function (ServiceContainer $container) {
        return new Controllers\LoginSubmitController($container->get("authService"), $container->get("session"));
    },
    'logoutSubmitController' => function (ServiceContainer $container) {
        return new Controllers\LogoutSubmitController($container->get("authService"));
    },
    "authService" => function (ServiceContainer $container) {
        return new Services\AuthService($container->get("connection"), $container->get("session"));
    },
    'notFoundController' => function () {
        return new Controllers\NotFoundController();
    },
    'forgotPasswordSubmitController' => function (ServiceContainer $container) {
        return new Controllers\ForgotPasswordSubmitController($container->get("request"), $container->get("forgotPasswordService"));
    },
    'forgotPasswordService' => function (ServiceContainer $container) {
        return new ForgotPasswordService($container->get("connection"), $container->get("mailer"), $container->get("baseUrl"));
    },
    'forgotPasswordController' => function (ServiceContainer $container) {
        return new Controllers\ForgotPasswordController($container->get("session"));
    },
    "mailer" => function (ServiceContainer $container) {
        $mailerConfig = $container->get("config")["mail"];
        $transport = (new Swift_SmtpTransport($mailerConfig["host"], $mailerConfig["port"]))
            ->setUsername($mailerConfig["username"])
            ->setPassword($mailerConfig["password"]);
        return new Swift_Mailer($transport);
    },
    'session' => function (ServiceContainer $container) {
        $sessionConfig = $container->get("config")["session"];
        return \Session\SessionFactory::build($sessionConfig["driver"], $sessionConfig["config"]);
    },
    'request' => function (ServiceContainer $container) {
        return new Request($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"], $container->get("session"), file_get_contents('php://input'), getallheaders(), $_COOKIE, $_POST);
    },
    'pipeline' => function (ServiceContainer $container) {
        $pipeline = new Middleware\MiddlewareStack();
        $authMiddleware = new AuthorizationMiddleware(["/"], $container->get("authService"), "/login");
        $dispatcherMiddleware = new Middleware\DispatchingMiddleware($container->get("dispatcher"), $container->get("responseFactory"));
        $pipeline->addMiddleware($authMiddleware);
        $pipeline->addMiddleware($dispatcherMiddleware);
        return $pipeline;
    },
    'dispatcher' => function (ServiceContainer $container) {
        $dispatcher = new Dispatcher($container, 'notFoundController@handle');
        $dispatcher->addRoute('/', 'homeController@handle');
        $dispatcher->addRoute('/image/(?<id>[\d]+)', 'singleImageController@display');
        $dispatcher->addRoute('/image/(?<id>[\d]+)/edit', 'singleImageEditController@edit', "POST");
        $dispatcher->addRoute('/image/(?<id>[\d]+)/delete', 'singleImageDeleteController@delete', "POST");

        $dispatcher->addRoute('/login', 'loginFormController@show');
        $dispatcher->addRoute('/logout', 'logoutSubmitController@submit');
        $dispatcher->addRoute('/login', 'loginSubmitController@submit', "POST");

        $dispatcher->addRoute('/forgotpass', 'forgotPasswordController@show');
        $dispatcher->addRoute('/forgotpass', 'forgotPasswordSubmitController@submit', "POST");

        return $dispatcher;
    }
];