<?php

namespace Tests\Functional;
use Platypus\Model\User;

class UserControllerTest extends BaseTestCase
{

    public function setUp() {
        $this->createApp();
        $this->beginTransaction();
    }

    public function tearDown() {
        $this->rollback();
    }

    public function test_UserRequest_returnsAllUsers() {
        $response = $this->runApp('GET', '/api/v1/user');
        $this->assertEquals(200, $response->getStatusCode());
        $users = json_decode($response->getBody());
        $this->assertTrue(is_array($users));
    }

    public function test_UserRequest_createUser() {
        $this->createTestUser();
        $this->assertTrue(User::where('mailaddress', 'test@mail.com')->first() != null);
    }

    public function test_UserRequest_createUser_alreadyExists() {
        $response = $this->makeCreateTestUserRequest();
        $responseFail = $this->makeCreateTestUserRequest();

        $this->assertEquals(409, $responseFail->getStatusCode());
    }

    public function test_UserRequest_createUser_invalidMail() {
        $responseFail = $this->makeCreateTestUserRequest("nomail");

        $this->assertEquals(422, $responseFail->getStatusCode());
    }

    public function test_UserRequest_createUser_shortPw() {
        $responseFail = $this->makeCreateTestUserRequest("valid@mail.com", "shortpw");

        $this->assertEquals(422, $responseFail->getStatusCode());
    }


    public function test_UserRequest_getUser() {
        $response = $this->makeCreateTestUserRequest();
        $this->assertEquals(200, $response->getStatusCode());

        $response = $this->runApp('GET', '/api/v1/user/' . json_decode($response->getBody())->new_user->id);

        $body = json_decode($response->getBody());
        $this->assertEquals('test@mail.com', $body->mailaddress);
        // make sure password is not readable
        $this->assertTrue(!isset($body->password));
    }
}
