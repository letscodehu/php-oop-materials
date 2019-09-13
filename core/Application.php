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
            $response = $this->container
                ->get("pipeline")
                ->pipe($this->container->get("request"), new Response("", [], 200, "OK"));
            $this->container->get('responseEmitter')->emit($response);
        } catch (\Exception $e) {
            logMessage('ERROR', $e->getMessage());
            die("Critical error occured during pageload. Please try again later.");
        }
    }

}