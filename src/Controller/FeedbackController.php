<?php

namespace Platypus\Controller;

use Interop\Container\ContainerInterface;
use Platypus\Model\User;

class FeedbackController
{
    private $feedbackService;

    public function __construct(ContainerInterface $ci)
    {
        $this->feedbackService = $ci->get('FeedbackService');
    }

    public function getFeedbacks($request, $response, $args)
    {
        $data = $this->feedbackService->getFeedbacks();

        //Code to define what to return
        $result = $data->map(function ($feedback){
            return $this->convertToCleanFeedback($feedback);
        });
        return $response->withJson($result, 200);
    }

    public function getFeedback($request, $response, $args)
    {
        $data = $this->feedbackService->getFeedback($args['id']);
        return $response->withJson($data, 200);
    }

    public function createFeedback($request, $response, $args)
    {
        //FIXME: make sure to use the user_id provided by the JWT token and not the one provided by the user
        //       a user shoulnd't be able to post on behalf of an other user
        //       Fix test case as well because user_id is passed at the moment
        $request_params = $request->getParsedBody();

        $createdFeedback = $this->feedbackService->createFeedback($request_params);

        if($createdFeedback === null) {
            return $response->withJson(["error" => "Failed to create feedback."], 422);
        }

        return $response->withJson(["success" => 1, "new_feedback" => $createdFeedback]);
    }

    private function convertToCleanFeedback($feedback)
    {
        return ['id' => $feedback->id, 'feedback_text' => $feedback->feedback_text, 'parent_id' => $feedback->parent_id, 'hashtags' => $feedback->hashtags->map(function ($hashtag) {
            return $this->covertToCleanHashtag($hashtag);
        }),'last_modified' => $feedback->updated_at->format("Y-m-d H:i:s"),'creation_date' => $feedback->created_at->format("Y-m-d H:i:s"),'votes_count' => ($feedback->votes->where('direction',1)->count() - $feedback->votes->where('direction',0)->count())

        ];

    }

    private function covertToCleanHashtag($hashtag)
    {
        return ['id' => $hashtag->id, 'hashtext' => $hashtag->hashtext,'hash_types_id' => $hashtag->hashtypes_id,'last_modified' => $hashtag->updated_at->format("Y-m-d H:i:s")

        ];
    }
}
