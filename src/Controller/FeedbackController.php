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
        return $response->withJson($data, 200);
    }
}