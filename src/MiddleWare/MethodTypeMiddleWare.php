<?php

declare(strict_types=1);

namespace src\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class MethodTypeMiddleware
{
    public function __invoke(Request $request, Response $response, $next)
    {
        $methodType = $request->getMethod();
        $allowed = func_get_args();

        if (!in_array($methodType, $allowed)) {
            $errorResponse = [
                'error' => 'Method Not Allowed',
                'message' => 'This endpoint does not allow the specified request method.',
                'supplied' => $methodType,
                'allowed' => implode(",", $allowed)
            ];
            $response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $response
                ->withHeader('Allow', implode(",", $allowed))
                ->withStatus(405);
        }

        return $next($request, $response);
    }
}
