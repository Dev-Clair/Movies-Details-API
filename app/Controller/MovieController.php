<?php

declare(strict_types=1);

namespace app\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class MovieController extends AbsController
{
    public function index(Request $request, Response $response)
    {
        // Retrieve the MovieModel instance from the container
        $movieModel = $this->container->get('MovieModel');

        // Now you can use $movieModel to interact with the MovieModel.
    }
}
