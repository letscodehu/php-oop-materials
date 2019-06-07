<?php


class Application {

    private $container;

    public function __construct(ServiceContainer $container) {
        $this->container = $container;
    }

    public function start(string $basePath) {
        $this->container->put('basePath', $basePath);
        ob_start();
        $uri = $_SERVER["REQUEST_URI"];
        $cleaned = explode("?", $uri)[0];    
        $this->container->get("not found");    
        $controllerResult = $this->container->get('dispatcher')->dispatch($cleaned);
        $response = $this->container->get('responseFactory')->createResponse($controllerResult);
        $this->container->get('responseEmitter')->emit($response);
    }

}