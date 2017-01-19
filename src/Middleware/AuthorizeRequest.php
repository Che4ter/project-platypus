<?php

namespace Platypus\Middleware;
use Interop\Container\ContainerInterface;
use Platypus\Model\Role;

class AuthorizeRequest {
    protected $container;
    protected $leastRequiredRole;

    public function __construct(ContainerInterface $container, $leastRequiredRole) {
        $this->container = $container;
        $this->leastRequiredRole = $leastRequiredRole;
        if($leastRequiredRole < Role::ID_GUEST && $leastRequiredRole > Role::ID_ADMIN) {
            throw new InvalidArgumentException("leastRequiredRole must be between Role::ID_GUEST and Role::ID_ADMIN");
        }
    }

    public function __invoke($request, $response, $next) {
        if (!isset($this->container["jwt"])
            || ($this->container->get("jwt")->role_id < $this->leastRequiredRole)) {
            $errorMsg = "You don't have the sufficient role to be able to perform this request.";
            return $response->withJson(["errors" => [$errorMsg]], 401);
        }
        return $next($request, $response);
    }
}
