<?php

use src\Controller\MovieController;


$app->get('/v1/movies', MovieController::class . ':get');

$app->post('/v1/movies', MovieController::class . ':post');

$app->put('/v1/movies/{uid}', MovieController::class . ':put');

$app->delete('/v1/movies/{uid}', MovieController::class . ':delete');

$app->patch('/v1/movies/{uid}', MovieController::class . ':patch');

$app->get('/v1/movies/{numberPerPage}', MovieController::class . ':getSelection');

$app->get('/v1/movies/{numberPerPage}/sort/{fieldToSort}', MovieController::class . ':getSortedSelection');
