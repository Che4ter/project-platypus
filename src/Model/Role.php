<?php

namespace Platypus\Model;

class Role extends \Illuminate\Database\Eloquent\Model
{
    /**
     * Get the users for the role.
     */
    public function users()
    {
        return $this->hasMany('Platypus\Model\User');
    }
}