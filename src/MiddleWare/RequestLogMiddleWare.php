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
        $requestInfo = [
            'URI' => (string) $request->getUri(),
            'HEADERS' => json_encode($request->getHeaders()),
            'BODY' => (string) $request->getBody(),
        ];

        $this->logToFile($requestInfo);

        return $handler->handle($request);
    }
}
