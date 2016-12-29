<?php

namespace Platypus\Controller;
use Interop\Container\ContainerInterface;
use Platypus\Model\User;

class UserController
{
    private $userService;

    public function __construct(ContainerInterface $ci)
    {
        $this->userService = $ci->get('UserService');
    }

    public function getUsers($request, $response, $args)
    {
        $users = $this->userService->getUsers();
        return $response->withJson($users, 200);
    }

    public function getUser($request, $response, $args)
    {
        $user = $this->userService->getUser($args['id']);
        if($user === null) {
            return $response->withJson(["error" => "User doesn't exist."], 404);
        }
        return $response->withJson($user, 200);
    }

    public function createUser($request, $response, $args)
    {
        $request_params = $request->getParsedBody();
        if($this->userService->userWithEmailExists($request_params["mailaddress"])) {
            // fixme: maybe solve this using the illuminate validators
            return $response->withJson(["error" => "User already exists."], 409);
        }

        $userCreated = $this->userService->createUser($request_params);

        if(!$userCreated) {
            return $response->withJson(["error" => "Failed to create user."], 422);
        }

        return $response->withJson(["success" => 1]);
    }

}
