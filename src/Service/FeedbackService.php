<?php

namespace Platypus\Service;
use Interop\Container\ContainerInterface;
use Platypus\Model\Feedback;

class FeedbackService
{
    protected $ci;

    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
    }

    public function getFeedbacks($lastsync)
    {
        $date = new \DateTime();
        $date->setTimestamp($lastsync);

        return Feedback::with(array('votes'=>function($query){
            $query->select('id','feedback_id','user_id','direction');
        },'hashtags'))->where('updated_at','>',$date)->get();
    }


    public function getFeedback($id) {
        return Feedback::find($id);
    }

    public function createFeedback($request_params)
    {
        $new_feedback = new Feedback();
        $new_feedback->feedback_text = $request_params["feedback_text"];
        $new_feedback->moods_id = $request_params["moods_id"];
        $new_feedback->user_id = $request_params["user_id"];
        // $new_feedback->hashtags = $request_params["hashtags"];
        $new_feedback->save();
        return $new_feedback;
    }
}
