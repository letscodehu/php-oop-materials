<?php

class Dispatcher {

    private $container;
    private $notFoundController;
    private $routes = [];

    public function __construct(ServiceContainer $container, $notFoundController) {
        $this->notFoundController = $notFoundController;
        $this->container = $container;
    }
        
    public function addRoute($action, $callable, $method = "GET") {
        $pattern = "%^$action$%";
        $this->routes[strtoupper($method)][$pattern] = $callable;
    }

    public function dispatch($action) {
        $method = $_SERVER["REQUEST_METHOD"]; // POST GET PATCH DELETE
        if (array_key_exists($method, $this->routes)) {
            foreach ($this->routes[$method] as $pattern => $callable) {
                if (preg_match($pattern, $action, $matches)) {
                   return $this->invokeHandler($callable, $matches);
                }
            }
        }
        return $this->invokeHandler($this->notFoundController, $matches);
    }

    private function invokeHandler($callable, $matches) {
        if (strpos($callable, '@')) {
            return $this->invokeFromContainer($callable, $matches);
        } else {
            return $callable($matches);
        }
    }


    private function invokeFromContainer(string $callable, $matches) {
        $pair = explode('@', $callable);
        $controller = $pair[0];
        $method = $pair[1];
        return $this->container->get($controller)->$method($matches);
    }

}