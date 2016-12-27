<?php

namespace Platypus\Controller;
use Interop\Container\ContainerInterface;

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
}