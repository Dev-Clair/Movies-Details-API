<?php

namespace src\Throwable;

use Throwable;
use Psr\Http\Message\ResponseInterface as Response;

class ResourceThrowable
{
    public static function handleException(Throwable $exception, Response $response): Response
    {
        $exceptionResponse = [
            'code' => $exception->getCode(),
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine()
        ];
        $response->getBody()->write(json_encode($exceptionResponse, JSON_PRETTY_PRINT));

        return $response
            ->withHeader('Content-Type', 'application/json; charset=UTF-8')
            ->withStatus(500);
    }


    public static function handleError(Throwable $error, Response $response): Response
    {
        $errorResponse = [
            'code' => $error->getCode(),
            'message' => $error->getMessage(),
            'file' => $error->getFile(),
            'line' => $error->getLine()
        ];

        $response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

        return $response
            ->withHeader('Content-Type', 'application/json; charset=UTF-8')
            ->withStatus(500);
    }
}
