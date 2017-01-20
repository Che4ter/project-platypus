<?php

namespace Platypus\Model;
/*DATABASE TABLE
+-----------------+------------------+------+-----+---------+----------------+
| Field           | Type             | Null | Key | Default | Extra          |
+-----------------+------------------+------+-----+---------+----------------+
| id              | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
| feedback_text   | varchar(500)     | NO   |     | NULL    |                |
| parent_id       | int(10) unsigned | YES  | MUL | NULL    |                |
| moods_id        | int(10) unsigned | YES  | MUL | NULL    |                |
| feedback_status | int(10) unsigned | YES  |     | NULL    |                |
| is_deleted      | binary(1)        | YES  |     | 0       |                |
| user_id         | int(10) unsigned | NO   | MUL | NULL    |                |
| created_at      | datetime         | YES  |     | NULL    |                |
| updated_at      | datetime         | YES  |     | NULL    |                |
+-----------------+------------------+------+-----+---------+----------------+
E DATABASE TABLE*/

class Feedback extends \Illuminate\Database\Eloquent\Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'feedback';


    /**
     * Get the user for the feedback.
     */
    public function user()
    {
        return $this->belongsTo('Platypus\Model\User');
    }

    /**
     * Get the user for the feedback.
     */
    public function moods()
    {
        return $this->belongsTo('Platypus\Model\Mood');
    }

    /**
     * Get the feedback that owns the comment.
     */
    public function feedback()
    {
        return $this->belongsTo('Platypus\Model\Feedback');
    }


    /**
     * The hashtags that belong to the feedback.
     */
    public function hashtags()
    {
        return $this->belongsToMany('Platypus\Model\Hashtag');
    }

    /**
     * Get the votes for the feedback.
     */
    public function votes()
    {
        return $this->hasMany('Platypus\Model\Vote');
    }
}
