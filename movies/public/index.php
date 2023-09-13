<?php

use Slim\Factory\AppFactory;
use src\Middleware\MethodTypeMiddleware;
use src\Middleware\ContentTypeMiddleware;
use src\Throwable\ResourceThrowable;
use Nyholm\Psr7\Factory\Psr17Factory;


require __DIR__ . '/../vendor/autoload.php';

// set_error_handler(ResourceThrowable::class . ':handleError');
// set_exception_handler(ResourceThrowable::class . ':handleException');

$psr17Factory = new Psr17Factory();

AppFactory::setPsr17Factory($psr17Factory);
$app = AppFactory::create();

// Register Middleware
// $methodTypeMiddleware = new MethodTypeMiddleware();
// $contentTypeMiddleware = new ContentTypeMiddleware();

// Define Routes/Endpoints and Middleware
$app->get('/v1/movies', \src\Controller\MovieController::class . ':get')
    ->add(new \src\Middleware\MethodTypeMiddleware(['GET', 'POST']));

// $app->post('/v1/movies', \src\Controller\MovieController::class . ':post')
//     ->add($methodTypeMiddleware(['POST']))
//     ->add($contentTypeMiddleware);

// $app->put('/v1/movies/{uid}', \src\Controller\MovieController::class . ':put')
//     ->add($methodTypeMiddleware(['PUT', 'PATCH', 'DELETE']))
//     ->add($contentTypeMiddleware);

// $app->delete('/v1/movies/{uid}', \src\Controller\MovieController::class . ':delete')
//     ->add($methodTypeMiddleware(['PUT', 'PATCH', 'DELETE']))
//     ->add($contentTypeMiddleware);

// $app->patch('/v1/movies/{uid}', \src\Controller\MovieController::class . ':patch')
//     ->add($methodTypeMiddleware(['PUT', 'PATCH', 'DELETE']))
//     ->add($contentTypeMiddleware);

// $app->get('/v1/movies/{numberPerPage}', \src\Controller\MovieController::class . ':getSelection')
//     ->add($methodTypeMiddleware(['GET']));

// $app->get('/v1/movies/{numberPerPage}/sort/{fieldToSort}', \src\Controller\MovieController::class . ':getSortedSelection')
//     ->add($methodTypeMiddleware(['GET']));


$app->run();
