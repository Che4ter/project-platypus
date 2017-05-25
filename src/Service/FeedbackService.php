<?php

namespace Platypus\Service;
use Interop\Container\ContainerInterface;
use Platypus\Model\Feedback;
use Platypus\Model\Vote;

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
        $date->setTimestamp($lastsync);/*
        $result = Feedback::with(array('votes'=>function($query) use($date){
           $query->select('id','feedback_id','user_id','direction','updated_at')
           ->where('updated_at','>',$date);
          },'hashtags'))
        ->get();
        return $result;*/

        $date = new \DateTime();
        $date->setTimestamp($lastsync);
        $result = Feedback::with(array('votes'=>function($query){
            $query->select('id','feedback_id','user_id','direction','updated_at');
        },'hashtags'))
            ->where("updated_at", '>', $date)
            ->get();
        return $result;
    }


    public function getFeedback($id) {
        return Feedback::find($id);
    }

    public function voteFeedback($request_params,$feedbackId)
    {
        $userid = $this->ci->get('jwt')->sub;

        if(!Vote::where('user_id',$userid)
            ->where('feedback_id',$feedbackId)
            ->exists()){
            $new_vote = new Vote();
            $new_vote->direction = $request_params["direction"];
            $new_vote->user_id = $userid;
            $new_vote->feedback_id = $feedbackId;
            $new_vote->save();

            Feedback::where('id', $feedbackId)->first()->touch();
            return $new_vote;
        }
        else
        {
            return null;
        }
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
