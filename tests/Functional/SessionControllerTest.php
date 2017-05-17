<?php

namespace Tests\Functional;
use Platypus\Model\User;

class SessionControllerTest extends BaseTestCase
{

    private $user;

    private $originalJwtSecret;
    private $originalJwtTokenTimeout;

    public function setUp() {
        $this->createApp();
        $this->beginTransaction();
        $this->user = $this->createTestUser('test@stud.hslu.ch', '12345678');
        $this->originalJwtSecret = env('JWT_SECRET', '');
        $this->originalJwtTokenTimeout = env('JWT_TOKEN_TIMEOUT', '');
    }

    public function tearDown() {
        $this->rollback();
        putenv('JWT_SECRET=' . $this->originalJwtSecret);
        putenv('JWT_TOKEN_TIMEOUT=' . $this->originalJwtTokenTimeout);
    } 

    public function test_SessionRequest_getToken_noMailaddress() {
        $responseFail = $this->runApp('POST', '/api/v1/auth/token', [
            'password' => '1234'
        ]);
        $this->assertEquals(422, $responseFail->getStatusCode());
    }

    public function test_SessionRequest_getToken_noPassword() {
        $responseFail = $this->runApp('POST', '/api/v1/auth/token', [
            'mailaddress' => 'test@mail.com'
        ]);
        $this->assertEquals(422, $responseFail->getStatusCode());
    }


    public function test_SessionRequest_getToken_wrongPassword() {
        $responseFail = $this->runApp('POST', '/api/v1/auth/token', [
            'mailaddress' => $this->user->mailaddress,
            'password' => 'this is the wrong password, surely'
        ]);

        $this->assertEquals(403, $responseFail->getStatusCode());
    }

    public function test_SessionRequest_getToken_noSecretConfigured() {
        putenv('JWT_SECRET=');  //is restored on tear down

        $responseFail = $this->runApp('POST', '/api/v1/auth/token', [
            'mailaddress' => $this->user->mailaddress,
            'password' => '12345678'
        ]);

        $this->assertEquals(500, $responseFail->getStatusCode());
    }

    public function test_SessionRequest_getToken_noTokenTimeoutConfigured() {
        putenv('JWT_TOKEN_TIMEOUT=');  //is restored on tear down

        $responseFail = $this->runApp('POST', '/api/v1/auth/token', [
            'mailaddress' => $this->user->mailaddress,
            'password' => '12345678'
        ]);

        $this->assertEquals(500, $responseFail->getStatusCode());
    }

    public function test_SessionRequest_getToken_success() {
        $this->aquireAuthTokenForUser($this->user->mailaddress, '12345678');
    }

    public function test_SessionRequest_useInvalidTokenForAuthentication_success() {
    }

    public function test_SessionRequest_useTokenForAuthentication_success() {
        $this->aquireAuthTokenForUser($this->user->mailaddress, '12345678');
    }
}
