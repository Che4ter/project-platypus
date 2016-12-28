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

    public function getUser($id)
    {
        return User::find($id);
    }

    public function createUser($request_params)
    {
        //todo: check if user is authenticated
        //todo: -> check if user is admin
        //todo: ->-> add not whitelisted fields to user objects like user role
        //todo: else set default values

        $new_user = new User($request_params);

        //todo: add password hashing!!!
        //todo: add error handling
        //$new_user->password = password_hash($request_params["password"]);
        $new_user->password = $request_params["password"];
        $new_user->role_id = 1;
        $new_user->status = 0;
        if($new_user->save())
        {
            return 201;
        }
        else
        {
            return 500;
        }
    }
}