<?php

use src\Controller\MovieController;
use \src\Middleware\MethodTypeMiddleware;
use \src\Middleware\ContentTypeMiddleware;

$app->get('/v1/movies', MovieController::class . ':get')->add(new MethodTypeMiddleware(["GET", "POST"]));

$app->post('/v1/movies', MovieController::class . ':post')->add(new MethodTypeMiddleware(["GET", "POST"]))->add(new ContentTypeMiddleware);

$app->put('/v1/movies/{uid}', MovieController::class . ':put')->add(new ContentTypeMiddleware);

$app->delete('/v1/movies/{uid}', MovieController::class . ':delete')->add(new ContentTypeMiddleware);

$app->patch('/v1/movies/{uid}', MovieController::class . ':patch');

$app->get('/v1/movies/{numberPerPage}', MovieController::class . ':getSelection');

$app->get('/v1/movies/{numberPerPage}/sort/{fieldToSort}', MovieController::class . ':getSortedSelection');

$app->get('/v1/movies/search/{title}', MovieController::class . ':getSearch');
