<?php

namespace Tests\Functional;
use Platypus\Model\Feedback;

class FeedbackControllerTest extends BaseTestCase
{

    public function setUp() {
        $this->createApp();
        $this->beginTransaction();
    }

    public function tearDown() {
        $this->rollback();
    }

    private function createTestFeedback($user = null) {
        if($user == null) {
            $user = json_decode($this->createTestUser()->getBody())->new_user;
        }

        return $this->runApp('POST', '/api/v1/feedback', [
            'feedback_text' => 'Does this even work?',
            'user_id' => $user->id
        ]);
    }

    public function test_FeedbackRequest_returnsAllFeedbacks() {
        $response = $this->runApp('GET', '/api/v1/feedback');
        $this->assertEquals(200, $response->getStatusCode());
        $feedbacks = json_decode($response->getBody());
        $this->assertTrue(is_array($feedbacks));
    }

    public function test_FeedbackRequest_createFeedback() {
        $user = json_decode($this->createTestUser()->getBody())->new_user;
        $response = $this->createTestFeedback($user);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(Feedback::where('user_id', $user->id)->first() != null);
    }

    public function test_FeedbackRequest_getFeedback() {
        $response = $this->createTestFeedback();
        $response = $this->runApp('GET', '/api/v1/feedback/' . json_decode($response->getBody())->new_feedback->id);

        $this->assertEquals(200, $response->getStatusCode());
        $body = json_decode($response->getBody());
        $this->assertEquals('Does this even work?', $body->feedback_text);
    }
}
