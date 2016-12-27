<?php

namespace Tests\Functional;

class UserControllerTest extends BaseTestCase
{
    public function testUserRequest_returnsAllUsers()
    {
        $response = $this->runApp('GET', '/user');
        $this->assertEquals(201, $response->getStatusCode());

        $this->assertContains('Rob', (string)$response->getBody());
    }
}