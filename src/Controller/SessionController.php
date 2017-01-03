<?php

namespace Platypus\Controller;
use Interop\Container\ContainerInterface;
use Platypus\Model\User;
use Firebase\JWT\JWT;

class SessionController
{
    private $userService;
    private $sessionService;

    public function __construct(ContainerInterface $ci)
    {
        $this->userService = $ci->get('UserService');
        $this->sessionService = $ci->get('SessionService');
    }

    /**
     * POST /api/v1/auth/get_token
     *
     * Get an JWT token to authorize on API.
     *
     * Provide your email address and password you received during your registration (`POST / /api/v1/user`).
     *
     * The JWT token should then be passed by the `Authorization: Bearer <token>`-HTTP-Header.
     *
     * '''
     * {
     *   "mailaddress": "test@mail.com",
     *   "password": "<password>"
     * }
     *
     * Returns 422 when fields are missing. {"errors" => ["<errormessage", ..]}
     * Returns 201 when authentication succeed {"succees" => 1, "user" => <userfields>]]
     * Returns 403 when authentication failed {"errors" => []]}
     * Returns 500 when JWT_SECRET or JWT_TOKEN_TIMEOUT is *not* configured in the .env file.
     * '''
     */
    public function getToken($request, $response, $args)
    {
        if($request->getAttribute('has_errors')) {
            $errors = $request->getAttribute('errors');
            return $response->withJson(["errors" => $errors], 422);
        }

        $request_params = $request->getParsedBody();
        $user = $this->userService->getUserByMailaddress($request_params["mailaddress"]);
        if($user !== null && password_verify($request_params['password'], $user->password)) {

            $jwt_token = $this->sessionService->generateJWT($user, env("JWT_SECRET"), env("JWT_TOKEN_TIMEOUT"));
            if($jwt_token === null) {
                return $response->withJson(["errors" => "Error in JWT configuration. Please configure JWT_SECRET and JWT_TOKEN_TIMEOUT."], 500);
            }

            // don't save the token yet 
            //$user->token = $jwt_token;
            //$user->save();
            return $response->withJson(["success" => 1, "token" => $jwt_token, "user" => $user], 201);
        } else {
            return $response->withJson(["errors" => ["Incorrect mailaddress and/or password."]], 403);
        }


    }
}
