<?php

use src\Controller\MovieController;
use \src\Middleware\MethodTypeMiddleware;
use \src\Middleware\ContentTypeMiddleware;
use src\Middleware\RequestLogMiddleWare;
use src\Middleware\ResponseLogMiddleWare;

$app->get('/v1', MovieController::class . ':getAPIInfo')
    ->add(new RequestLogMiddleWare)
    ->add(new ResponseLogMiddleWare);

$app->get('/v1/movies', MovieController::class . ':get')
    ->add(new RequestLogMiddleWare)
    ->add(new MethodTypeMiddleware(["GET", "POST"]))
    ->add(new ResponseLogMiddleWare);

$app->post('/v1/movies', MovieController::class . ':post')
    ->add(new RequestLogMiddleWare)
    ->add(new MethodTypeMiddleware(["GET", "POST"]))
    ->add(new ContentTypeMiddleware)
    ->add(new ResponseLogMiddleWare);

$app->put('/v1/movies/{uid}', MovieController::class . ':put')
    ->add(new RequestLogMiddleWare)
    ->add(new MethodTypeMiddleware(["PUT", "DELETE", "PATCH"]))
    ->add(new ContentTypeMiddleware)
    ->add(new ResponseLogMiddleWare);

$app->patch('/v1/movies/{uid}', MovieController::class . ':patch')
    ->add(new RequestLogMiddleWare)
    ->add(new MethodTypeMiddleware(["PUT", "DELETE", "PATCH"]))
    ->add(new ContentTypeMiddleware);

$app->delete('/v1/movies/{uid}', MovieController::class . ':delete')
    ->add(new RequestLogMiddleWare)
    ->add(new MethodTypeMiddleware(["PUT", "DELETE", "PATCH"]))
    ->add(new ResponseLogMiddleWare);

$app->get('/v1/movies/{numberPerPage}', MovieController::class . ':getSelection')
    ->add(new RequestLogMiddleWare)
    ->add(new MethodTypeMiddleware(["GET"]))
    ->add(new ResponseLogMiddleWare);

$app->get('/v1/movies/{numberPerPage}/sort/{fieldToSort}', MovieController::class . ':getSortedSelection')
    ->add(new RequestLogMiddleWare)
    ->add(new MethodTypeMiddleware(["GET"]))
    ->add(new ResponseLogMiddleWare);

$app->get('/v1/movies/search/{title}', MovieController::class . ':getSearch')
    ->add(new RequestLogMiddleWare)
    ->add(new MethodTypeMiddleware(["GET"]))
    ->add(new ResponseLogMiddleWare);
