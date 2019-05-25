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
    'homeController' => function() {
        return new Controllers\HomeController();
    },
    'dispatcher' => function(ServiceContainer $container) {
        $dispatcher = new Dispatcher($container, 'notFoundController');
        $dispatcher->addRoute('/', 'homeController@handle');
        $dispatcher->addRoute('/about', 'aboutController');
        $dispatcher->addRoute('/image/(?<id>[\d]+)', 'singleImageController');
        $dispatcher->addRoute('/image/(?<id>[\d]+)/edit', 'singleImageEditController', "POST");
        $dispatcher->addRoute('/image/(?<id>[\d]+)/delete', 'singleImageDeleteController', "POST");
        
        $dispatcher->addRoute('/login', 'loginFormController');
        $dispatcher->addRoute('/logout', 'logoutSubmitController');
        $dispatcher->addRoute('/login', 'loginSubmitController', "POST");
        return $dispatcher;
    }
];