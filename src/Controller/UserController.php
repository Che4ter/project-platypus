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
        $data = $this->userService->getUsers();
        return $response->withJson($data, 200);
    }

    public function getUser($request, $response, $args)
    {
        $data = $this->userService->getUser($args['id']);
        return $response->withJson($data, 200);
    }

    public function createUser($request, $response, $args)
    {
        $request_params = $request->getParsedBody();

        $response_code = $this->userService->createUser($request_params);

        return $response->withStatus($response_code);
    }

}