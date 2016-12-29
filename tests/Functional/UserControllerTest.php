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

    public function test_UserRequest_returnsAllUsers()
    {
        $response = $this->runApp('GET', '/api/v1/user');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_UserRequest_createUser() {
        $response = $this->runApp('POST', '/api/v1/user', [
            'mailaddress' => 'test@mail.com',
            'password' => 'testpw',
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(User::where('mailaddress', 'test@mail.com')->first() != null);
    }

    public function test_UserRequest_createUser_alreadyExists() {
        $responseCreate = $this->runApp('POST', '/api/v1/user', [
            'mailaddress' => 'test@mail.com',
            'password' => 'testpw',
        ]);

        $responseFail = $this->runApp('POST', '/api/v1/user', [
            'mailaddress' => 'test@mail.com',
            'password' => 'testpw2',
        ]);

        $this->assertEquals(409, $responseFail->getStatusCode());
    }
}
