<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use \src\Controller\MovieController;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// Add Routing Middleware
$app->addRoutingMiddleware();

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Define Routes/Endpoints and Middleware
$app->get('/v1/movies', MovieController::class, ':get');

$app->post('/v1/movies', MovieController::class . ':post');

// $app->put('/v1/movies/{uid}', MovieController::class . ':put');

// $app->delete('/v1/movies/{uid}', MovieController::class . ':delete');

// $app->patch('/v1/movies/{uid}', MovieController::class . ':patch');

// $app->get('/v1/movies/{numberPerPage}', MovieController::class . ':getSelection');

// $app->get('/v1/movies/{numberPerPage}/sort/{fieldToSort}', MovieController::class . ':getSortedSelection');


$app->run();
