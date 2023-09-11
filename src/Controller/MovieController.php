<?php

declare(strict_types=1);

namespace src\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class MovieController extends AbsController
{
    public function index(Request $request, Response $response)
    {
        $movieModel = $this->container->get('MovieModel');
    }
}
