<?php

declare(strict_types=1);

namespace src\Middleware;

use Slim\Psr7\Response as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;

class ContentTypeMiddleware
{
    public function __invoke(Request $request, RequestHandlerInterface $handler)
    {
        $contentType = $request->getHeaderLine('Content-Type');

        if (strpos($contentType, 'application/json') === false) {
            $errorResponse = [
                'error' => 'Invalid Content-Type',
                'message' => 'This endpoint requires a JSON Content-Type header.',
                'supplied' => $contentType,
                'required' => 'application/json; charset=UTF-8'
            ];
            $response = new Response();
            $response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $response
                ->withHeader('Content-Type', 'application/json; charset=UTF-8')
                ->withStatus(400);
        }

        return $handler->handle($request);
    }
}
