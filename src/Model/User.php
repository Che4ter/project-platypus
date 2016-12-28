<?php

namespace Platypus\Model;

class User extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['mailaddress'];
    public $timestamps = false;

    /**
     * Get the roles for the user.
     */
    public function role()
    {
        return $this->belongsTo('Platypus\Model\Role');
    }
}