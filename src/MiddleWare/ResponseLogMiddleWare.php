<?php

declare(strict_types=1);

namespace src\MiddleWare;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response as Response;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use src\Trait\ResponseLogTrait as ResponseLog;

class ResponseLogMiddleWare
{
    use ResponseLog;

    public function __invoke(Request $request, Handler $handler): Response
    {
        $this->logResponse($handler->handle($request));
        return $handler->handle($request);
    }

    public function logResponse(Response $response): void
    {
        $responseLog = [
            "response_status_code" => $response->getStatusCode(),
            "reponse_headers" => $response->getHeaders()
        ];

        $this->responseLog($responseLog);
    }
}
