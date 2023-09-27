<?php

declare(strict_types=1);

namespace src\Middleware;

use Slim\Psr7\Response as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use src\Trait\LogToFileMiddleWareTrait as LogToFile;

class RequestLogMiddleware
{
    use LogToFile;

    public function __invoke(Request $request, Handler $handler): Response
    {
        $requestID = "request" . random_int(1, 1000000);
        $requestTime = new \DateTime('now');
        $requestLog = [
            "request_id" => $requestID,
            "request_time" => $requestTime,
            "request_uri" => (string) $request->getUri(),
            "request_content_type" => $request->getHeaderLine('Content-Type'),
            "request_client" => $request->getHeaderLine('Client')
        ];

        $this->logToFile($requestLog);

        return $handler->handle($request);
    }
}
