<?php

namespace Platypus\Middleware;
use Interop\Container\ContainerInterface;
use Platypus\Model\Role;

class AddJwtToRequest {
    protected $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function __invoke($request, $response, $next) {
        $isAuthenticated = isset($this->container["jwt"]);
        $request = $request->withAttribute('has_user', $isAuthenticated);
        if($isAuthenticated) {
            $request = $request->withAttribute('user', $this->container["jwt"]);
        }
        return $next($request, $response);
    }
}
