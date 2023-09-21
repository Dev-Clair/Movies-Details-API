<?php

declare(strict_types=1);

namespace src\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use src\Model\MovieModel;


/**
 * Handles GET/POST/PUT/PATCH/DELETE request endpoints
 * 
 * @var MovieModel $movieModel
 * 
 */
class MovieController extends AbsController
{
    public function __construct()
    {
        $movieModel = new MovieModel(databaseName: "movies");
        parent::__construct($movieModel);
    }


    /**
     * Handles GET request for fetching movies
     * 
     */
    public function get(Request $request, Response $response, array $args): Response
    {
        $resource = $this->movieModel->retrieveAllMovies("movie_details");

        if (!array($resource)) {
            $errorResponse = $this->errorResponse('Internal server error', 'Cannot retrieve resource', $resource);
            $response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $response
                ->withHeader('Content-Type', 'application/json; charset=UTF-8')
                ->withStatus(500);
        }

        $successResponse = $this->successResponse('OK', 'Resource retrieved successfully', $resource);
        $response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

        return $response
            ->withHeader('Content-Type', 'application/json; charset=UTF-8')
            ->withStatus(200);
    }


    /**
     * Handles POST request for creating a movie
     *
     */
    public function post(Request $request, Response $response, array $args): Response
    {
        $validatedData = $this->validateData($request, $response);
        $resource = $this->movieModel->createMovie("movie_details", $validatedData);

        if ($resource !== true) {

            $errorResponse = $this->errorResponse('Internal server error', 'Cannot create resource', (bool) $resource);
            $response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $response
                ->withHeader('Content-Type', 'application/json; charset=UTF-8')
                ->withStatus(500);
        }

        $successResponse = $this->successResponse('Request successful', 'New Resource Created', (bool) $resource);
        $response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

        return $response
            ->withHeader('Content-Type', 'application/json; charset=UTF-8')
            ->withStatus(200);
    }


    /**
     * Handles PUT request for updating a movie
     * 
     */
    public function put(Request $request, Response $response, array $args): Response
    {
        $requestAttribute = $args['uid'] ?? null;

        $this->validateRequestAttribute($request, $response, $requestAttribute);
        $this->validateResource($request, $response, $requestAttribute);

        $validatedData = $this->validateData($request, $response);
        $resource = $this->movieModel->updateMovie("movie_details", $validatedData, ['uid' => 'uid'], $requestAttribute);

        if ($resource !== true) {
            $errorResponse = $this->errorResponse('Internal server error', 'Cannot modify resource', (bool) $resource);
            $response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $response
                ->withHeader('Content-Type', 'application/json; charset=UTF-8')
                ->withStatus(500);
        }

        $successResponse = $this->successResponse('OK', 'Resource modified successfully', (bool) $resource);
        $response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

        return $response
            ->withHeader('Content-Type', 'application/json; charset=UTF-8')
            ->withStatus(200);
    }


    /**
     * Handles PATCH request for partially updating a movie
     * 
     */
    public function patch(Request $request, Response $response, array $args): Response
    {
        $requestAttribute = $args['uid'] ?? null;

        $this->validateRequestAttribute($request, $response, $requestAttribute);
        $this->validateResource($request, $response, $requestAttribute);

        $sanitizedData = $this->sanitizeData();
        $resource = $this->movieModel->updateMovie("movie_details", $sanitizedData, ['uid' => 'uid'], $requestAttribute);

        if ($resource !== true) {
            $errorResponse = $this->errorResponse('Internal server error', 'Cannot modify resource', (bool) $resource);
            $response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $response
                ->withHeader('Content-Type', 'application/json; charset=UTF-8')
                ->withStatus(500);
        }

        $successResponse = $this->successResponse('OK', 'Resource modified successfully', (bool) $resource);
        $response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

        return $response
            ->withHeader('Content-Type', 'application/json; charset=UTF-8')
            ->withStatus(200);
    }


    /**
     * Handles DELETE request for deleting a movie
     * 
     */
    public function delete(Request $request, Response $response, array $args): Response
    {
        $requestAttribute = $args['uid'] ?? null;

        $this->validateRequestAttribute($request, $response, $requestAttribute);
        $this->validateResource($request, $response, $requestAttribute);

        $resource = $this->movieModel->deleteMovie("movie_details", ['uid' => 'uid'], $requestAttribute);


        if ($resource !== true) {
            $errorResponse = $this->errorResponse('Internal server error', 'Cannot delete resource', (bool) $resource);
            $response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $response
                ->withHeader('Content-Type', 'application/json; charset=UTF-8')
                ->withStatus(500);
        }

        $successResponse = $this->successResponse('OK', 'Resource deleted successfully', (bool) $resource);
        $response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

        return $response
            ->withHeader('Content-Type', 'application/json; charset=UTF-8')
            ->withStatus(200);
    }


    /**
     * Handles GET request for fetching a selection movies
     * 
     */
    public function getSelection(Request $request, Response $response, array $args): Response
    {
        $numberPerPage = $args['numberPerPage'] ?? null;

        $resource = $this->movieModel->retrieveAllMovies("movie_details");

        if (!array($resource)) {
            $errorResponse = $this->errorResponse('Internal server error', 'Cannot retrieve resource', $resource);
            $response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $response
                ->withHeader('Content-Type', 'application/json; charset=UTF-8')
                ->withStatus(500);
        }

        $successResponse = $this->successResponse('OK', 'Resource retrieved successfully', array_slice($resource, 0, $numberPerPage));
        $response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

        return $response
            ->withHeader('Content-Type', 'application/json; charset=UTF-8')
            ->withStatus(200);
    }


    /**
     * Handles GET request for fetching a sorted selection of movies
     * 
     */
    public function getSortedSelection(Request $request, Response $response, array $args): Response
    {
        $numberPerPage = $args['numberPerPage'] ?? null;
        $fieldToSort = $args['fieldToSort'] ?? null;

        $resource = $this->movieModel->retrieveAllMovies("movie_details");

        if (!array($resource)) {
            $errorResponse = $this->errorResponse('Internal server error', 'Cannot retrieve resource', $resource);
            $response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $response
                ->withHeader('Content-Type', 'application/json; charset=UTF-8')
                ->withStatus(500);
        }

        // $resource = ksort($resource);
        $successResponse = $this->successResponse('OK', 'Resource retrieved successfully', array_slice($resource, 0, $numberPerPage));
        $response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

        return $response
            ->withHeader('Content-Type', 'application/json; charset=UTF-8')
            ->withStatus(200);
    }
}
