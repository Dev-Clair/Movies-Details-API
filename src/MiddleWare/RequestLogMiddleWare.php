<?php

declare(strict_types=1);

namespace src\Middleware;

use Slim\Psr7\Response as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use src\Middleware\LogToFileMiddleWareTrait as LogToFile;

class RequestLogMiddleware
{
    use LogToFile;

    public function __invoke(Request $request, Handler $handler): Response
    {
        $requestID = "request" . random_int(1, 1000000);
        $requestTime = new \DateTime('now', new \DateTimeZone('UTC'));
        $requestLog = [
            "request_id" => $requestID,
            "request_time" => $requestTime,
            "request" => [
                'uri' => (string) $request->getUri(),
                'headers' => $request->getHeaders()
            ]
        ];

        $this->logToFile($requestLog);

        return $handler->handle($request);
    }
}
