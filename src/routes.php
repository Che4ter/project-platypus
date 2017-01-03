<?php

use DavidePastore\Slim\Validation\Validation;
use Respect\Validation\Validator as v;
// Routes


// Find more info about what validators are avilalbe here: https://github.com/Respect/Validation/blob/master/docs/VALIDATORS.md

$app->get('/', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});


$app->group('/api/v1', function() use ($app) {
    //USER
    $app->get('/user', '\Platypus\Controller\UserController:getUsers');
    $app->get('/user/{id}', '\Platypus\Controller\UserController:getUser');

    $app->post('/user', '\Platypus\Controller\UserController:createUser')
        ->add(new Validation([
            'mailaddress' => v::email(),
            'password' => v::length(8, null)
        ]));

    //AUTHENTICATION
    $app->post('/auth/token', '\Platypus\Controller\SessionController:getToken')
        ->add(new Validation([
            'mailaddress' => v::notEmpty(),
            'password' => v::notEmpty()
        ]));


    //FEEDBACK
    $app->get('/feedback', '\Platypus\Controller\FeedbackController:getFeedback');

    $app->post('/feedback', '\Platypus\Controller\FeedbackController:createFeedback');
});
