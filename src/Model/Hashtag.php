<?php

namespace Platypus\Model;

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