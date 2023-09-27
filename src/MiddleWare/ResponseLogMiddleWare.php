<?php

declare(strict_types=1);

namespace src\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response as Response;
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
        $responseLog = [
            "response_status_code" => $response->getStatusCode(),
            "reponse_headers" => $response->getHeaders()
        ];

        $this->logToFile($responseLog);
    }
}
