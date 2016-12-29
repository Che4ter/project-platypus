<?php

namespace Platypus\Model;

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