<?php

namespace Platypus\Middleware;


class ValidateRequest {

    public function __invoke($request, $response, $next) {
        if($request->getAttribute('has_errors')) {
            $errors = $request->getAttribute('errors');
            return $response->withJson(["errors" => $errors], 422);
        }

        return $next($request, $response);
    }

}
