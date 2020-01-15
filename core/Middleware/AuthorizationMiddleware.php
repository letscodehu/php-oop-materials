<?php


namespace Middleware;


use Services\AuthService;

class AuthorizationMiddleware implements Middleware
{
    /**
     * @var string[]
     */
    private $protectedUrls;

    /**
     * @var AuthService
     */
    private $authService;

    /**
     * @var string
     */
    private $loginUrl;

    /**
     * AuthorizationMiddleware constructor.
     * @param string[] $protectedUrls
     * @param AuthService $authService
     * @param string $loginUrl
     */
    public function __construct(array $protectedUrls, AuthService $authService, $loginUrl)
    {
        $this->protectedUrls = $protectedUrls;
        $this->authService = $authService;
        $this->loginUrl = $loginUrl;
    }

    function process(\Request $request, \Response $response, callable $next)
    {
        if (in_array($request->getUri(), $this->protectedUrls) && !$this->authService->check()) {
            return \Response::redirect($this->loginUrl);
        }
        return $next($request, $response);
    }
}