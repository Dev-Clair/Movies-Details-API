<?php

declare(strict_types=1);

namespace src\MiddleWare;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response as Response;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use src\Trait\RequestLogTrait as RequestLog;

class RequestLogMiddleWare
{
    use RequestLog;

    public function __invoke(Request $request, Handler $handler): Response
    {
        $this->logRequest($request);
        return $handler->handle($request);
    }

    public function logRequest(Request $request): void
    {
        $requestID = "request" . random_int(1, 1000000);
        $requestTime = new \DateTime('now');
        $requestLog = [
            "request_id" => $requestID,
            "request_time" => $requestTime,
            "request_uri" => (string) $request->getUri(),
            "request_content_type" => $request->getHeaderLine('Content-Type'),
            "request_method" => $request->getMethod()
        ];

        $this->requestLog($requestLog);
    }
}
