<?php

namespace Platypus\Model;
/*DATABASE TABLE
+-------------+------------------+------+-----+---------+----------------+
| Field       | Type             | Null | Key | Default | Extra          |
+-------------+------------------+------+-----+---------+----------------+
| id          | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
| feedback_id | int(10) unsigned | NO   | MUL | NULL    |                |
| user_id     | int(10) unsigned | NO   | MUL | NULL    |                |
| direction   | binary(1)        | YES  |     | NULL    |                |
| created_at  | datetime         | YES  |     | NULL    |                |
| updated_at  | datetime         | YES  |     | NULL    |                |
+-------------+------------------+------+-----+---------+----------------+
E DATABASE TABLE*/

class Vote extends \Illuminate\Database\Eloquent\Model
{
}
