<?php

declare(strict_types=1);

namespace src\Controller;

use src\Model\MovieModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;

class MovieController extends AbsController
{
    private MovieModel $movieModel;

    public function __construct(MovieModel $movieModel)
    {
        $this->movieModel = new $movieModel;
    }

    /**
     * Handles GET request for fetching movies
     * 
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function get(Request $request, Response $response, array $args): string
    {
        $result = $this->movieModel->retrieveAllMovies("movie_details");

        return json_encode([
            'status' =>  200,
            'body' => $result
        ], JSON_PRETTY_PRINT);
    }

    /**
     * Handles POST request for creating a movie
     * 
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function post(Request $request, Response $response): string
    {
        $result = $this->movieModel->createMovie("movie_details", [])
            ?
            json_encode([
                'status' => 201,
                'message' => 'resource created'
            ], JSON_PRETTY_PRINT)
            :
            json_encode([
                'status' => '',
                'message' => 'cannot create resource'
            ], JSON_PRETTY_PRINT);

        return $result;
    }

    /**
     * Handles PUT request for updating a movie
     * 
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function put(Request $request, Response $response, array $args): string
    {
        $result = $this->movieModel->updateMovie("movie_details", [], '', '')
            ?
            json_encode([
                'status' => 200,
                'message' => 'resource modified (entirely)'
            ], JSON_PRETTY_PRINT)
            :
            json_encode([
                'status' => '',
                'message' => 'cannot modify resource'
            ], JSON_PRETTY_PRINT);

        return $result;
    }


    /**
     * Handles PATCH request for partially updating a movie
     * 
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function patch(Request $request, Response $response, array $args): string
    {
        $result = $this->movieModel->updateMovie("movie_details", [], '', '')
            ?
            json_encode([
                'status' => 200,
                'message' => 'resource modified (partially)'
            ], JSON_PRETTY_PRINT)
            :
            json_encode([
                'status' => '',
                'message' => 'cannot modify resource'
            ], JSON_PRETTY_PRINT);

        return $result;
    }


    /**
     * Handles DELETE request for deleting a movie
     * 
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function delete(Request $request, Response $response, array $args): string
    {
        $result = $this->movieModel->deleteMovie("movie_details", '', '')
            ?
            json_encode([
                'status' => 200,
                'message' => 'resource deleted'
            ], JSON_PRETTY_PRINT)
            :
            json_encode([
                'status' => '',
                'message' => 'cannot delete resource'
            ], JSON_PRETTY_PRINT);

        return $result;
    }

    /**
     * Handles GET request for fetching movies
     * 
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function getSelection(Request $request, Response $response, array $args): string
    {
        $result = $this->movieModel->retrieveAllMovies("movie_details");

        return json_encode([
            'status' =>  200,
            'body' => $result
        ], JSON_PRETTY_PRINT);
    }

    /**
     * Handles GET request for fetching movies
     * 
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function getSortedSelection(Request $request, Response $response, array $args): string
    {
        $result = $this->movieModel->retrieveAllMovies("movie_details");

        return json_encode([
            'status' =>  200,
            'body' => $result
        ], JSON_PRETTY_PRINT);
    }
}
