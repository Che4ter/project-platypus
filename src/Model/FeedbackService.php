<?php

namespace Platypus\Model;
use Interop\Container\ContainerInterface;

class FeedbackService
{
    protected $ci;

    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
    }

    public function getFeedback()
    {

        return Feedback::with(array('votes'=>function($query){
            $query->select('id','feedback_id','user_id','direction');
        },'hashtags','moods'=>function($query){
            $query->select('id','moodname');
        }))->get();
    }
}