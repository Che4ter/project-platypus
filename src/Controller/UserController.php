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
            return $response->withJson(["errors" => ["User doesn't exist."]], 404);
        }
        return $response->withJson($user, 200);
    }

    public function createUser($request, $response, $args)
    {
        $request_params = $request->getParsedBody();
        if($this->userService->userWithEmailExists($request_params["mailaddress"])) {
            return $response->withJson(["errors" => ["User already exists."]], 409);
        }

        $createdUser = $this->userService->createUser($request_params);

        if($createdUser === null) {
            return $response->withJson(["errors" => ["Failed to create user."]], 422);
        }

        return $response->withJson(["success" => 1, "new_user" => $createdUser]);
    }

}
