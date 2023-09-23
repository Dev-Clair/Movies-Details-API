<?php

declare(strict_types=1);

namespace src\Middleware;

use Slim\Psr7\Response as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as MiddleWare;
use Psr\Http\Server\RequestHandlerInterface as Handler;

class MethodTypeMiddleware // implements Middleware
{
    protected array $allowedMethods;

    public function __construct(array $allowedMethods)
    {
        $this->allowedMethods = $allowedMethods;
    }

    public function __invoke(Request $request, Handler $handler): Response|Handler
    {
        $methodType = $request->getMethod();

        if (!in_array($methodType, $this->allowedMethods)) {
            $errorResponse = [
                'error' => 'Method Not Allowed',
                'message' => 'This endpoint does not allow the specified request method.',
                'supplied' => $methodType,
                'allowed' => implode(",", $this->allowedMethods)
            ];
            $response = new Response();
            $response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $response
                ->withHeader('Allow', implode(",", $this->allowedMethods))
                ->withStatus(405);
        }

        return $handler->handle($request);
    }
}
