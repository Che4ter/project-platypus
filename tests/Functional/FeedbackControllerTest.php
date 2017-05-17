<?php

namespace Tests\Functional;
use Platypus\Model\Feedback;

class FeedbackControllerTest extends BaseTestCase
{

    public function setUp() {
        $this->createApp();
        $this->beginTransaction();
        $this->user = $this->createAuthenticatedTestUser('feedbackTester@stud.hslu.ch', 'feedback');
    }

    public function tearDown() {
        $this->rollback();
    }

    private function makeCreateTestFeedbackRequest($user = null) {
        return $this->runAppAs($user, 'POST', '/api/v1/feedback', [
            'feedback_text' => 'Does this even work?',
            'moods_id' => 1,
            'user_id' => $user->id //FIXME: should not be passed, but taken from the JWT token
        ]);
    }

    public function test_FeedbackRequest_returnsAllFeedbacks() {
        $response = $this->runApp('GET', '/api/v1/feedback');
        $this->assertEquals(200, $response->getStatusCode());
        $feedbacks = json_decode($response->getBody());
        $this->assertTrue(is_array($feedbacks));
    }

    public function test_FeedbackRequest_createFeedback() {
        #$this->markTestIncomplete(
            #'Ignored because it fails currently. Please fix @mogria'
        #);
        $response = $this->makeCreateTestFeedbackRequest($this->user);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(Feedback::where('user_id', $this->user->id)->first() != null);
    }

    public function test_FeedbackRequest_getFeedback() {
        $response = $this->makeCreateTestFeedbackRequest($this->user);
        $json_body = json_decode($response->getBody());
        $this->assertFalse(is_null($json_body));

        // this request doesn't need to be authenticated :-)
        $response = $this->runApp('GET', '/api/v1/feedback/' . $json_body->new_feedback->id);
        $this->assertEquals(200, $response->getStatusCode());
        $body = json_decode($response->getBody());
        $this->assertEquals('Does this even work?', $body->feedback_text);
    }
}
