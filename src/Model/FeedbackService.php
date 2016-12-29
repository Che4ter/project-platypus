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
        return Feedback::with("hashtags")->get();
    }
}