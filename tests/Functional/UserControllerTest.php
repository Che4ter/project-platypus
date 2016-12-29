<?php

namespace Tests\Functional;

class UserControllerTest extends BaseTestCase
{
    public function test_UserRequest_returnsAllUsers()
    {
        $response = $this->runApp('GET', '/api/v1/user');
        $this->assertEquals(200, $response->getStatusCode());
    }
}
