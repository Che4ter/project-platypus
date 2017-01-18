<?php

namespace Platypus\Model;

class Role extends \Illuminate\Database\Eloquent\Model
{
    const ID_GUEST = 0;
    const ID_USER = 1;
    const ID_ADMIN = 9;

    /**
     * Get the users for the role.
     */
    public function users()
    {
        return $this->hasMany('Platypus\Model\User');
    }
}
