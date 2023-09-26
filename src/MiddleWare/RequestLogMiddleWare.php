<?php

declare(strict_types=1);

namespace src\Middleware;

use Slim\Psr7\Response as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use src\Middleware\LogToFileTraitMiddleWare as LogToFile;

class RequestLogMiddleware
{
    use LogToFile;

    public function __invoke(Request $request, Handler $handler): Response|Handler
    {
        $requestID = "request" . random_int(1, 1000000);
        $requestTime = new \DateTime('now', new \DateTimeZone('UTC'));
        $requestLog = [
            "requestID" => $requestID,
            "requestTime" => $requestTime,
            "request" => [
                'URI' => (string) $request->getUri(),
                'HEADERS' => $request->getHeaders(),
                'BODY' => serialize($request->getBody()),
            ]
        ];

        $this->logToFile($requestLog);

        return $handler->handle($request);
    }
}
