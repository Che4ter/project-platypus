<?php

namespace Platypus\Model;
/*DATABASE TABLE
+------------------+------------------+------+-----+---------+----------------+
| Field            | Type             | Null | Key | Default | Extra          |
+------------------+------------------+------+-----+---------+----------------+
| id               | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
| rolename         | varchar(30)      | NO   |     | NULL    |                |
| can_delete       | binary(1)        | YES  |     | 0       |                |
| can_write        | binary(1)        | YES  |     | 0       |                |
| can_report       | binary(1)        | YES  |     | 0       |                |
| can_vote         | binary(1)        | YES  |     | 0       |                |
| can_edit_states  | binary(1)        | YES  |     | 0       |                |
| can_edit_users   | binary(1)        | YES  |     | 0       |                |
| can_edit_hashtag | binary(1)        | YES  |     | 0       |                |
| created_at       | datetime         | YES  |     | NULL    |                |
| updated_at       | datetime         | YES  |     | NULL    |                |
+------------------+------------------+------+-----+---------+----------------+
E DATABASE TABLE*/

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
