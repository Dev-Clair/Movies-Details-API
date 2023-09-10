<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// Inject Dependencies >> Instantiate and add MovieModel Class to the Container
$container = $app->getContainer();
$container->set('MovieModel', function ($container) {
    return new \app\Model\MovieModel(databaseName: "movies");
});

// Define Routes/Endpoints and Middleware
$app->run();
