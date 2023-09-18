<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// // Add Routing Middleware
// $app->addRoutingMiddleware();

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Define Routes/Endpoints and Middleware
require __DIR__ . '/../movies/endpoints.php';


$app->run();
