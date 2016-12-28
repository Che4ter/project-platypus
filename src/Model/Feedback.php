<?php

namespace Platypus\Model;

class Feedback extends \Illuminate\Database\Eloquent\Model
{
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
    public function mood()
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
    public function hashtag()
    {
        return $this->belongsToMany('Platypus\Model\Hashtag');
    }
}