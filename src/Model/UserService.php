<?php

namespace Platypus\Model;
use Interop\Container\ContainerInterface;

class UserService
{
    protected $ci;

    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
    }

    public function getUsers()
    {
        $data = array('name' => 'Rob', 'age' => 40);
        return $data;
    }
}