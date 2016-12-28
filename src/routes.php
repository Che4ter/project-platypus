<?php
// Routes

$app->get('/', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});


//USER
$app->get('/api/v1/user', '\Platypus\Controller\UserController:getUsers');
$app->get('/api/v1/user/{id}', '\Platypus\Controller\UserController:getUser');

$app->post('/api/v1/user', '\Platypus\Controller\UserController:createUser');

//FEEDBACK
$app->get('/api/v1/feedback', '\Platypus\Controller\FeedbackController:getFeedback');

//Authentication
$app->post('/api/v1/token', '\Platypus\Controller\AuthenticationController:getToken');
