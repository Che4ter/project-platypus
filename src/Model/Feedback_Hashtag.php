<?php

namespace Platypus\Model;
/*DATABASE TABLE
+-------------+------------------+------+-----+---------+----------------+
| Field       | Type             | Null | Key | Default | Extra          |
+-------------+------------------+------+-----+---------+----------------+
| id          | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
| hashtag_id  | int(10) unsigned | NO   | MUL | NULL    |                |
| feedback_id | int(10) unsigned | NO   | MUL | NULL    |                |
| created_at  | datetime         | YES  |     | NULL    |                |
| updated_at  | datetime         | YES  |     | NULL    |                |
+-------------+------------------+------+-----+---------+----------------+
E DATABASE TABLE*/

class Feedback_Hashtag extends \Illuminate\Database\Eloquent\Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'feedback_hashtag';
}
