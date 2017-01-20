<?php

namespace Platypus\Model;
/*DATABASE TABLE
+--------------+------------------+------+-----+---------+----------------+
| Field        | Type             | Null | Key | Default | Extra          |
+--------------+------------------+------+-----+---------+----------------+
| id           | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
| hashtext     | varchar(50)      | NO   | UNI | NULL    |                |
| hashtypes_id | int(10) unsigned | NO   | MUL | NULL    |                |
| created_at   | datetime         | YES  |     | NULL    |                |
| updated_at   | datetime         | YES  |     | NULL    |                |
+--------------+------------------+------+-----+---------+----------------+
E DATABASE TABLE*/

class Hashtag extends \Illuminate\Database\Eloquent\Model
{

    /**
     * The feedbacks that belong to the hashtag.
     */
    public function feedbacks()
    {
        return $this->belongsToMany('Platypus\Model\Feedback');
    }
}
