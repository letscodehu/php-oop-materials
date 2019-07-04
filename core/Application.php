<?php


class Application {

    private $container;

    public function __construct(ServiceContainer $container) {
        $this->container = $container;
    }

    public function start(string $basePath) {
        try {
            $this->container->put('basePath', $basePath);
            ob_start();
            $uri = $_SERVER["REQUEST_URI"];
            $cleaned = explode("?", $uri)[0];    
            $controllerResult = $this->container->get('dispatcher')->dispatch($cleaned);
            $response = $this->container->get('responseFactory')->createResponse($controllerResult);
            $this->container->get('responseEmitter')->emit($response);
        } catch (\Exception $e) {
            logMessage('ERROR', $e->getMessage());
            die("Critical error occured during pageload. Please try again later.");
        }
    }

}