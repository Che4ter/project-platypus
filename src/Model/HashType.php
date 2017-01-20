<?php

namespace Platypus\Model;
/*DATABASE TABLE
+----------------------+------------------+------+-----+---------+----------------+
| Field                | Type             | Null | Key | Default | Extra          |
+----------------------+------------------+------+-----+---------+----------------+
| id                   | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
| hashtype_description | varchar(50)      | YES  |     | NULL    |                |
| created_at           | datetime         | YES  |     | NULL    |                |
| updated_at           | datetime         | YES  |     | NULL    |                |
+----------------------+------------------+------+-----+---------+----------------+
E DATABASE TABLE*/

class HashType extends \Illuminate\Database\Eloquent\Model
{
}
