<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// Define Routes/Endpoints and Middleware
$app->get('/v1/movies', \src\Controller\MovieController::class . ':get');
$app->post('/v1/movies', \src\Controller\MovieController::class . ':post');
$app->put('/v1/movies/{uid}', \src\Controller\MovieController::class . ':put');
$app->delete('/v1/movies/{uid}', \src\Controller\MovieController::class . ':delete');
$app->patch('/v1/movies/{uid}', \src\Controller\MovieController::class . ':patch');
$app->get('/v1/movies/{numberPerPage}', \src\Controller\MovieController::class . ':getSelection');
$app->get('/v1/movies/{numberPerPage}/sort/{fieldToSort}', \src\Controller\MovieController::class . ':getSortedSelection');

$app->run();
