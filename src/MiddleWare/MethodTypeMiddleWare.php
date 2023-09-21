<?php

declare(strict_types=1);

namespace src\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class MethodTypeMiddleware
{
    public function __invoke(Request $request, Response $response, $next, array $allowedMethods)
    {
        $methodType = $request->getMethod();

        if (!in_array($methodType, $allowedMethods)) {
            $errorResponse = [
                'error' => 'Method Not Allowed',
                'message' => 'This endpoint does not allow the specified request method.',
                'supplied' => $methodType,
                'allowed' => implode(",", $allowedMethods)
            ];
            $response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $response
                ->withHeader('Allow', implode(",", $allowedMethods))
                ->withStatus(405);
        }

        return $next($request, $response);
    }
}
