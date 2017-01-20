<?php

namespace Platypus\Middleware;
use Interop\Container\ContainerInterface;
use Platypus\Model\Role;

class AuthorizeRequest {
    protected $leastRequiredRole;

    public function __construct($leastRequiredRole) {
        $this->leastRequiredRole = $leastRequiredRole;
        if($leastRequiredRole < Role::ID_GUEST && $leastRequiredRole > Role::ID_ADMIN) {
            throw new InvalidArgumentException("leastRequiredRole must be between Role::ID_GUEST and Role::ID_ADMIN");
        }
    }

    public function __invoke($request, $response, $next) {
        if (!$request->getAttribute('has_user')
            || ($request->getAttribute('user')->role_id < $this->leastRequiredRole)) {
            $errorMsg = "You don't have the sufficient role to be able to perform this request.";
            return $response->withJson(["errors" => [$errorMsg]], 401);
        }
        return $next($request, $response);
    }
}
