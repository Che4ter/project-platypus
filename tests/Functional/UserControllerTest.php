<?php

namespace Tests\Functional;

class UserControllerTest extends BaseTestCase
{
    public function test_UserRequest_returnsAllUsers()
    {
        $response = $this->runApp('GET', '/user');
        $this->assertEquals(200, $response->getStatusCode());
    }
}