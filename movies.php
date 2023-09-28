<?php

use src\Controller\MovieController;
use \src\Middleware\MethodTypeMiddleware;
use \src\Middleware\ContentTypeMiddleware;
use src\Middleware\RequestLogMiddleWare;
use src\Middleware\ResponseLogMiddleWare;

$app->get('/v1', MovieController::class . ':getAPIInfo')
    ->add(new ResponseLogMiddleWare)
    ->add(new RequestLogMiddleWare);

$app->get('/v1/movies', MovieController::class . ':get')
    ->add(new MethodTypeMiddleware(["GET", "POST"]))
    ->add(new ResponseLogMiddleWare)
    ->add(new RequestLogMiddleWare);

$app->post('/v1/movies', MovieController::class . ':post')
    ->add(new ContentTypeMiddleware)
    ->add(new MethodTypeMiddleware(["GET", "POST"]))
    ->add(new ResponseLogMiddleWare)
    ->add(new RequestLogMiddleWare);

$app->put('/v1/movies/{uid}', MovieController::class . ':put')
    ->add(new ContentTypeMiddleware)
    ->add(new MethodTypeMiddleware(["PUT", "DELETE", "PATCH"]))
    ->add(new ResponseLogMiddleWare)
    ->add(new RequestLogMiddleWare);

$app->patch('/v1/movies/{uid}', MovieController::class . ':patch')
    ->add(new ContentTypeMiddleware)
    ->add(new MethodTypeMiddleware(["PUT", "DELETE", "PATCH"]))
    ->add(new ResponseLogMiddleWare)
    ->add(new RequestLogMiddleWare);

$app->delete('/v1/movies/{uid}', MovieController::class . ':delete')
    ->add(new MethodTypeMiddleware(["PUT", "DELETE", "PATCH"]))
    ->add(new ResponseLogMiddleWare)
    ->add(new RequestLogMiddleWare);

$app->get('/v1/movies/{numberPerPage}', MovieController::class . ':getSelection')
    ->add(new MethodTypeMiddleware(["GET"]))
    ->add(new ResponseLogMiddleWare)
    ->add(new RequestLogMiddleWare);

$app->get('/v1/movies/{numberPerPage}/sort/{fieldToSort}', MovieController::class . ':getSortedSelection')
    ->add(new MethodTypeMiddleware(["GET"]))
    ->add(new ResponseLogMiddleWare)
    ->add(new RequestLogMiddleWare);

$app->get('/v1/movies/search/{title}', MovieController::class . ':getSearch')
    ->add(new MethodTypeMiddleware(["GET"]))
    ->add(new ResponseLogMiddleWare)
    ->add(new RequestLogMiddleWare);
