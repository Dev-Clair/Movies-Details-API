<?php

declare(strict_types=1);

namespace src\Middleware;

use Slim\Psr7\Response as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use src\Middleware\LogToFileTraitMiddleWare as LogToFile;

class ResponseLogMiddleware
{
    use LogToFile;

    public function __invoke(Request $request, Handler $handler): Response|Handler
    {
        $this->responseLog($handler->handle($request));
        return $handler->handle($request);
    }

    public function responseLog(Response $response): void
    {
        $responseInfo = [
            'STATUS CODE' => $response->getStatusCode(),
            'HEADERS' => json_encode($response->getHeaders()),
            'BODY' => (string) $response->getBody(),
        ];

        $this->logToFile($responseInfo);
    }
}
