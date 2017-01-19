<?php

use DavidePastore\Slim\Validation\Validation;
use Respect\Validation\Validator as v;
use Platypus\Middleware\ValidateRequest;
use Platypus\Middleware\AuthorizeRequest;
use Platypus\Model\Role;

// Routes


// Find more info about what validators are avilalbe here: https://github.com/Respect/Validation/blob/master/docs/VALIDATORS.md

$app->get('/', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});


// needs **NO authentication** with a JWT token
$app->group('/api/v1', function() use ($app) {
    // USER
    $app->post('/user', '\Platypus\Controller\UserController:createUser')
        ->add(new ValidateRequest())
        ->add(new Validation([
            'mailaddress' => v::email(),
            'password' => v::length(8, null)
        ]));

    // GET AUTHENTICATION TOKEN
    $app->post('/auth/token', '\Platypus\Controller\SessionController:getToken')
        ->add(new ValidateRequest())
        ->add(new Validation([
            'mailaddress' => v::notEmpty(),
            'password' => v::notEmpty()
        ]));


    //FEEDBACK
    $app->get('/feedback', '\Platypus\Controller\FeedbackController:getFeedbacks');
    $app->get('/feedback/{id}', '\Platypus\Controller\FeedbackController:getFeedback');
});

// needs authentication with a JWT token
$app->group('/api/v1', function() use ($app) {
    //USER
    $app->get('/user', '\Platypus\Controller\UserController:getUsers')
        ->add(new AuthorizeRequest($app->getContainer(), Role::ID_ADMIN));

    $app->get('/user/{id}', '\Platypus\Controller\UserController:getUser');

    $app->post('/feedback', '\Platypus\Controller\FeedbackController:createFeedback');

})->add(new AuthorizeRequest($app->getContainer(), Role::ID_USER))
    ->add(new \Slim\Middleware\JwtAuthentication([
        "secret" => env("JWT_SECRET"),
        "callback" => function($request, $response, $arguments) use ($app) {
            // store decoded jwt token in container
            $container = $app->getContainer();
            $container["jwt"] = $arguments["decoded"];
            return true;
        },
        "error" => function($request, $response, $args) {
            return $response->withJson(["errors" => ["JWT authentication via Authorization-HTTP-Header failed because of: " . $args['message']]], 401);
        }
    ]));
