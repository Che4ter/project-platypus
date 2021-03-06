<?php

// DIC configuration
$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// Service factory for the ORM
$container['db'] = function ($container) {
    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($container['settings']['db']);
    $capsule->getDatabaseManager()->setDefaultConnection('default');

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};

\Illuminate\Database\Eloquent\Model::setConnectionResolver($container->get('db')->getDatabaseManager());

$container['UserService'] = function ($c) {
    return new Platypus\Service\UserService($c);
};

$container['FeedbackService'] = function ($c) {
    return new Platypus\Service\FeedbackService($c);
};

$container['SessionService'] = function($c) {
    return new Platypus\Service\SessionService($c);
};


// The clients time must not be more than one minoute away from the server time.
Firebase\JWT\JWT::$leeway = 60;
