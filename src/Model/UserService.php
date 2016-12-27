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
        return User::all();
    }
}