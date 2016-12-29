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

    private function createTestUser() {
        return $this->runApp('POST', '/api/v1/user', [
            'mailaddress' => 'test@mail.com',
            'password' => 'testpw',
        ]);
    }

    public function test_UserRequest_returnsAllUsers()
    {
        $response = $this->runApp('GET', '/api/v1/user');
        $this->assertEquals(200, $response->getStatusCode());
        $users = json_decode($response->getBody());
        $this->assertTrue(is_array($users));
    }

    public function test_UserRequest_createUser() {
        $response = $this->createTestUser();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(User::where('mailaddress', 'test@mail.com')->first() != null);
    }

    public function test_UserRequest_createUser_alreadyExists() {
        $response = $this->createTestUser();
        $responseFail = $this->createTestUser();

        $this->assertEquals(409, $responseFail->getStatusCode());
    }

    public function test_UserRequest_getUser() {
        $response = $this->createTestUser();
        $response = $this->runApp('GET', '/api/v1/user/' . json_decode($response->getBody())->new_user->id);

        $this->assertEquals(200, $response->getStatusCode());
        $body = json_decode($response->getBody());
        $this->assertEquals('test@mail.com', $body->mailaddress);
        // make sure password is not readable
        $this->assertTrue(!isset($body->password));
    }
}
