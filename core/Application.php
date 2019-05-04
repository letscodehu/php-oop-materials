<?php


class Application {

    public function start() {
        ob_start();
        $uri = $_SERVER["REQUEST_URI"];
        $cleaned = explode("?", $uri)[0];
        $responseFactory = new ResponseFactory(new ViewRenderer());
        $responseEmitter = new ResponseEmitter();
        $dispatcher = new Dispatcher('Controllers\\NotFoundController');
        $dispatcher->addRoute('/', 'homeController');
        $dispatcher->addRoute('/about', 'aboutController');
        $dispatcher->addRoute('/image/(?<id>[\d]+)', 'singleImageController');
        $dispatcher->addRoute('/image/(?<id>[\d]+)/edit', 'singleImageEditController', "POST");
        $dispatcher->addRoute('/image/(?<id>[\d]+)/delete', 'singleImageDeleteController', "POST");
        
        $dispatcher->addRoute('/login', 'loginFormController');
        $dispatcher->addRoute('/logout', 'logoutSubmitController');
        $dispatcher->addRoute('/login', 'loginSubmitController', "POST");
        
        $controllerResult = $dispatcher->dispatch($cleaned);
        $response = $responseFactory->createResponse($controllerResult);
        $responseEmitter->emit($response);
        
    }


}