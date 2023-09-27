<?php

declare(strict_types=1);

namespace src\Middleware;

use Slim\Psr7\Response as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use src\Trait\LogToFileMiddleWareTrait as LogToFile;

class ResponseLogMiddleware
{
    use LogToFile;

    public function __invoke(Request $request, Handler $handler): Response
    {
        $this->responseLog($handler->handle($request));
        return $handler->handle($request);
    }

    public function responseLog(Response $response): void
    {
        $responseTime = new \DateTime('now', new \DateTimeZone('UTC'));
        $responseLog = [
            "responseTime" => $responseTime,
            "response" => [
                'STATUS CODE' => $response->getStatusCode(),
                'HEADERS' => $response->getHeaderLine('Content-Type'),
                'BODY' => serialize($response->getBody())
            ]
        ];

        $this->logToFile($responseLog);
    }
}
