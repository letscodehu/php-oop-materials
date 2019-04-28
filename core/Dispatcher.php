<?php

class Dispatcher {

    private $notFoundController;
    private $routes = [];

    public function __construct($notFoundController) {
        $this->notFoundController = $notFoundController;
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
                    return $callable($matches);
                }
            }
        }
        $fun = $this->notFoundController;
        return $fun();
    }

}