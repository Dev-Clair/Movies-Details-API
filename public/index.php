<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// Add Routing Middleware
$app->addRoutingMiddleware();

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Define a route/end-point for API Welcome info
$app->get('/v1', function (Request $request, Response $response) {
    $welcome_message = [
        'message' => "Hello there!, Welcome to movies_detail API",
        'status' => 'Active',
        'endpoints' => [
            'GET: /v1/movies' => 'Retrieves all available resources (movies)',
            'POST: /v1/movies' => 'Creates a resource (movie) on the server',
            'PUT: /v1/movies/{uid}' => 'Modifies an entire resource (movie) based on provided resource uid',
            'DELETE: /v1/movies/{uid}' => 'Deletes or removes resource (movie) based on provided resource uid',
            'PATCH: /v1/movies/{uid}' => 'Modifies specified parts of a resource (movie) based on provided resource uid',
            'GET: /v1/movies/{numberPerPage}' => 'Retrieves resources (movies) based on supplied query param {numberPerPage}',
            'GET: /v1/movies/{numberPerPage}/sort/{fieldToSort}' => 'Retrieves sorted resources (movies) based on supplied query params: {numberPerPage} and {fieldToSort}'
        ]
    ];

    $response->getBody()->write(json_encode($welcome_message, JSON_PRETTY_PRINT));
    return $response
        ->withHeader('Content-Type', 'application/json; charset=UTF-8')
        ->withStatus(200);
});

// Define routes/endpoints and middlewares for crud operations
require __DIR__ . '/../movies.php';

$app->run();
