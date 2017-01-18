<?php

namespace Tests\Functional;
use Platypus\Model\User;
use Platypus\Model\Role;

class UserControllerTest extends BaseTestCase
{

    public function setUp() {
        $this->createApp();
        $this->beginTransaction();
    }

    public function tearDown() {
        $this->rollback();
    }

    public function test_UserRequest_returnsAllUsers_forAdmin() {
        $adminUser = $this->createAuthenticatedTestUser('admin@yolo.com', '12345678', Role::ID_ADMIN);
        $response = $this->runAppAs($adminUser, 'GET', '/api/v1/user');
        $this->assertEquals(200, $response->getStatusCode());
        $users = json_decode($response->getBody());
        $this->assertTrue(is_array($users));
    }

    public function test_UserRequest_doesntReturnAllUsers_forRegularUser() {
        $user = $this->createAuthenticatedTestUser('user@yolo.com', '12345678', Role::ID_USER);
        $response = $this->runAppAs($user, 'GET', '/api/v1/user');
        $this->assertEquals(401, $response->getStatusCode());
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
        $user = $this->createAuthenticatedTestUser('testuser15@mail.com', '12345678');
        #$userToken = $this->aquireAuthTokenForUser('testuser15@mail.com', '12345678');
        $response = $this->runAppAs($user, 'GET', '/api/v1/user/' . $user->id);

        $body = json_decode($response->getBody());
        $this->assertEquals('testuser15@mail.com', $body->mailaddress);
        // make sure password is not readable
        $this->assertTrue(!isset($body->password));
    }
}
