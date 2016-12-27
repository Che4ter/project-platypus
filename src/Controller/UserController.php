<?php

namespace Platypus\Controller;
use Interop\Container\ContainerInterface;

class UserController
{
    protected $ci;

    //Constructor
    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
    }

    public function getUsers($request, $response, $args)
    {
        $data = array('name' => 'Rob', 'age' => 40);
        return $response->withJson($data, 201);
    }
}