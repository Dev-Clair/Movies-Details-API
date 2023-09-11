<?php

declare(strict_types=1);

namespace src\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ContentTypeMiddleware
{
    public function __invoke(Request $request, Response $response, $next)
    {
        $contentType = $request->getHeaderLine('Content-Type');

        if (strpos($contentType, 'application/json') === false) {
            $errorResponse = [
                'error' => 'Invalid Content-Type',
                'message' => 'This endpoint requires a JSON Content-Type header.',
                'contentType' => $contentType
            ];
            $response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        }

        return $next($request, $response);
    }
}
