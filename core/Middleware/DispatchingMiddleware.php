<?php

namespace Middleware;


class DispatchingMiddleware implements Middleware {

    private $dispatcher;
    private $responseFactory;

    public function __construct(\Dispatcher $dispatcher, \ResponseFactory $responseFactory) {
        $this->dispatcher = $dispatcher;
        $this->responseFactory = $responseFactory;
    }

    function process(\Request $request, \Response $response, callable $next) {
        $controllerResult = $this->dispatcher->dispatch($request);
        return $this->responseFactory->createResponse($controllerResult, $request->getSession()->toArray());
    }

}