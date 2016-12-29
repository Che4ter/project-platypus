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

    public function userWithEmailExists($email) {
        if(is_null(User::where('mailaddress','=', $email)->first()))
            return false;
        else
            return true;
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

        //todo: add error handling
        //todo: remove salt from db
        $new_user->password = password_hash($request_params["password"], PASSWORD_BCRYPT);
        $new_user->role_id = 1;
        $new_user->status = 0;
        $new_user->save();
        return $new_user;
    }
}
