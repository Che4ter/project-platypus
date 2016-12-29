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

    public function getFeedback($request, $response, $args)
    {
        $data = $this->feedbackService->getFeedback();

        //Code to define what to return
        /*$data->map(function ($feedback){
            return $this->convertToCleanFeedback($feedback);
        });*/
        return $response->withJson($data, 200);
    }

    public function createFeedback($request, $response, $args)
    {
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
        })

        ];

    }

    private function covertToCleanHashtag($hashtag)
    {
        return ['id' => $hashtag->id, 'hashtext' => $hashtag->hashtext

        ];
    }
}