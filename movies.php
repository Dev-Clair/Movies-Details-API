<?php

use src\Controller\MovieController;
use src\Middleware\MethodTypeMiddleware;
use src\Middleware\ContentTypeMiddleware;
use src\Middleware\ResponseLogMiddleWare;
use src\Middleware\RequestLogMiddleWare;

$app->get('/v1', MovieController::class . ':getAPIInfo')
    ->add(new ResponseLogMiddleWare)
    ->add(new MethodTypeMiddleware(["GET"]))
    ->add(new RequestLogMiddleWare);

$app->get('/v1/movies', MovieController::class . ':get')
    ->add(new ResponseLogMiddleWare)
    ->add(new MethodTypeMiddleware(["GET", "POST"]))
    ->add(new RequestLogMiddleWare);

$app->post('/v1/movies', MovieController::class . ':post')
    ->add(new ResponseLogMiddleWare)
    ->add(new MethodTypeMiddleware(["GET", "POST"]))
    ->add(new ContentTypeMiddleware)
    ->add(new RequestLogMiddleWare);

$app->put('/v1/movies/{uid}', MovieController::class . ':put')
    ->add(new ResponseLogMiddleWare)
    ->add(new MethodTypeMiddleware(["PUT", "DELETE", "PATCH"]))
    ->add(new ContentTypeMiddleware)
    ->add(new RequestLogMiddleWare);

$app->patch('/v1/movies/{uid}', MovieController::class . ':patch')
    ->add(new ResponseLogMiddleWare)
    ->add(new MethodTypeMiddleware(["PUT", "DELETE", "PATCH"]))
    ->add(new ContentTypeMiddleware)
    ->add(new RequestLogMiddleWare);

$app->delete('/v1/movies/{uid}', MovieController::class . ':delete')
    ->add(new ResponseLogMiddleWare)
    ->add(new MethodTypeMiddleware(["PUT", "DELETE", "PATCH"]))
    ->add(new RequestLogMiddleWare);

$app->get('/v1/movies/{numberPerPage}', MovieController::class . ':getSelection')
    ->add(new ResponseLogMiddleWare)
    ->add(new MethodTypeMiddleware(["GET"]))
    ->add(new RequestLogMiddleWare);

$app->get('/v1/movies/{numberPerPage}/sort/{fieldToSort}', MovieController::class . ':getSortedSelection')
    ->add(new ResponseLogMiddleWare)
    ->add(new MethodTypeMiddleware(["GET"]))
    ->add(new RequestLogMiddleWare);

$app->get('/v1/movies/search/{title}', MovieController::class . ':getSearch')
    ->add(new ResponseLogMiddleWare)
    ->add(new MethodTypeMiddleware(["GET"]))
    ->add(new RequestLogMiddleWare);
