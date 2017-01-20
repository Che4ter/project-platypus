<?php

namespace Platypus\Model;
/*DATABASE TABLE
+-------------+------------------+------+-----+---------+----------------+
| Field       | Type             | Null | Key | Default | Extra          |
+-------------+------------------+------+-----+---------+----------------+
| id          | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
| mailaddress | varchar(150)     | YES  | UNI | NULL    |                |
| password    | varchar(255)     | NO   |     | NULL    |                |
| role_id     | int(10) unsigned | NO   | MUL | NULL    |                |
| status      | int(10) unsigned | NO   |     | NULL    |                |
| created_at  | datetime         | YES  |     | NULL    |                |
| updated_at  | datetime         | YES  |     | NULL    |                |
+-------------+------------------+------+-----+---------+----------------+
E DATABASE TABLE*/

class User extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['mailaddress'];


    protected $hidden = ['password', 'salt'];

    /**
     * Get the roles for the user.
     */
    public function role()
    {
        return $this->belongsTo('Platypus\Model\Role');
    }
}
