<?php
// Routes

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

    $app->post('/user', '\Platypus\Controller\UserController:createUser');

    //FEEDBACK
    $app->get('/feedback', '\Platypus\Controller\FeedbackController:getFeedback');

    //Authentication
    $app->post('/token', '\Platypus\Controller\AuthenticationController:getToken');

});
