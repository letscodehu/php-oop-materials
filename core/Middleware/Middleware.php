<?php 

namespace Middleware;

interface Middleware {
    function process(\Request $request, \Response $response, callable $next);
}