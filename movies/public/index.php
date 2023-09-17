<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use src\Controller\MovieController;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// // Add Routing Middleware
// $app->addRoutingMiddleware();

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// // Define Routes/Endpoints and Middleware
// $app->get('v1/movies', MovieController::class . ':get');

// $app->post('v1/movies', MovieController::class . ':post');

// $app->put('v1/movies/{uid}', MovieController::class . ':put');

// $app->delete('v1/movies/{uid}', MovieController::class . ':delete');

// $app->patch('v1/movies/{uid}', MovieController::class . ':patch');

// $app->get('v1/movies/{numberPerPage}', MovieController::class . ':getSelection');

// $app->get('v1/movies/{numberPerPage}/sort/{fieldToSort}', MovieController::class . ':getSortedSelection');

$app->get('v1/movies', function (Request $request, Response $response, $args) {
    $resource = MovieController::class . 'get';
    $response->getBody()->write(json_encode($resource, JSON_PRETTY_PRINT));

    return $response
        ->withHeader('Content-Type', 'application/json; charset=UTF-8')
        ->withStatus(200);
});

$app->post('v1/movies', function (Request $request, Response $response, $args) {
    $resource = MovieController::class . 'post';
    $response->getBody()->write(json_encode($resource, JSON_PRETTY_PRINT));

    return $response
        ->withHeader('Content-Type', 'application/json; charset=UTF-8')
        ->withStatus(201);
});


$app->run();
