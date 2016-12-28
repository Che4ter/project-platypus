<?php

namespace Platypus\Model;

class User extends \Illuminate\Database\Eloquent\Model
{
    /**
     * Get the roles for the user.
     */
    public function role()
    {
        return $this->belongsTo('Platypus\Model\Role');
    }
}