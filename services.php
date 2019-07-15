<?php

return [
    "responseFactory" => function(ServiceContainer $container) {
        return new ResponseFactory($container->get("viewRenderer"));
    },
    "viewRenderer" => function(ServiceContainer $container) {
        return new ViewRenderer($container->get("basePath"));
    },
    'responseEmitter' => function() {
        return new ResponseEmitter();
    },
    'homeController' => function(ServiceContainer $container) {
        return new Controllers\HomeController($container->get("photoService"));
    },
    "config" => function(ServiceContainer $container) {
        $base = $container->get("basePath");
        return include_once $base."/config.php";
    },
    "connection" => function (ServiceContainer $container) {
        $config = $container->get("config");
        $connection = mysqli_connect($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
        if (!$connection) {
            throw new SqlException('Connection error: '. mysqli_error($connection));
        } 
        return $connection;
    },
    "photoService" => function(ServiceContainer $container) {
        return new Services\PhotoService($container->get("connection"));
    },
    'singleImageController' => function(ServiceContainer $container) {
        return new Controllers\SingleImageController($container->get("photoService"));
    },
    'singleImageEditController' => function() {
        return new Controllers\SingleImageEditController();
    },
    'singleImageDeleteController' => function() {
        return new Controllers\SingleImageDeleteController();
    },
    'loginFormController' => function() {
        return new Controllers\LoginFormController();
    },
    'loginSubmitController' => function(ServiceContainer $container) {
        return new Controllers\LoginSubmitController($container->get("authService"));
    },
    'logoutSubmitController' => function(ServiceContainer $container) {
        return new Controllers\LogoutSubmitController($container->get("authService"));
    },
     "authService" => function(ServiceContainer $container) {
        return new Services\AuthService($container->get("connection"));
    },
    'notFoundController' => function() {
        return new Controllers\NotFoundController();
    },
    'dispatcher' => function(ServiceContainer $container) {
        $dispatcher = new Dispatcher($container, 'notFoundController@handle');
        $dispatcher->addRoute('/', 'homeController@handle');
        $dispatcher->addRoute('/image/(?<id>[\d]+)', 'singleImageController@display');
        $dispatcher->addRoute('/image/(?<id>[\d]+)/edit', 'singleImageEditController@edit', "POST");
        $dispatcher->addRoute('/image/(?<id>[\d]+)/delete', 'singleImageDeleteController@delete', "POST");
        
        $dispatcher->addRoute('/login', 'loginFormController@show');
        $dispatcher->addRoute('/logout', 'logoutSubmitController@submit');
        $dispatcher->addRoute('/login', 'loginSubmitController@submit', "POST");
        return $dispatcher;
    }
];