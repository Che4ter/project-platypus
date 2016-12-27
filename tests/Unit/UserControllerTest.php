<?php

namespace Tests\Unit;

use Platypus\Controller\UserController;
use Platypus\Model\UserService;
use Slim\Container;
use Slim\Http\Response;

class UserControllerTest extends \PHPUnit_Framework_TestCase
{
    public function test_getUser_callsUserService()
    {
        $userServiceMock = $this->createMock(UserService::class);
        $userServiceMock
            ->expects($this->once())
            ->method('getUsers');

        $container = new Container();
        $container['UserService'] = $userServiceMock;

        $userController = new UserController($container);
        $responseMock = $this->createMock(Response::class);

        $userController->getUsers(null, $responseMock, null);
    }
}