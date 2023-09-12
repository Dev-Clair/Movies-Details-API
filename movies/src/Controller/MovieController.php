<?php

declare(strict_types=1);

namespace src\Controller;

use src\Model\MovieModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


/**
 * Handles GET/POST/PUT/PATCH/DELETE request endpoints
 * 
 * @var MovieModel $movieModel
 * @var Request $request
 * @var Response $response
 * 
 */
class MovieController extends AbsController
{
    public function __construct(MovieModel $movieModel, Request $request, Response $response)
    {
        parent::__construct($movieModel, $request, $response);
    }


    /**
     * Handles GET request for fetching movies
     * 
     */
    public function get(): Response
    {
        $result = $this->movieModel->retrieveAllMovies("movie_details");
        $response_code = $this->response->getStatusCode();

        if ($response_code !== 200) {
            $errorResponse = $this->errorResponse($this->response->getReasonPhrase(), 'Cannot retrieve resource', $result);
            $this->response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $this->response
                ->withHeader('Content-Type', 'application/json; charset=UTF-8')
                ->withStatus(500);
        }

        $successResponse = $this->successResponse($this->response->getReasonPhrase(), 'Resource retrieved successfully', $result);
        $this->response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

        return $this->response
            ->withHeader('Content-Type', 'application/json; charset=UTF-8')
            ->withStatus(200);
    }


    /**
     * Handles POST request for creating a movie
     *
     */
    public function post(): Response
    {
        $validatedData = $this->validateData();
        $result = $this->movieModel->createMovie("movie_details", $validatedData);
        $response_code = $this->response->getStatusCode();

        if ($response_code !== 201) {

            $errorResponse = $this->errorResponse($this->response->getReasonPhrase(), 'Cannot create resource', (bool) $result);
            $this->response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $this->response
                ->withHeader('Content-Type', 'application/json; charset=UTF-8')
                ->withStatus(500);
        }

        $successResponse = $this->successResponse($this->response->getReasonPhrase(), 'Resource created successfully', (bool) $result);
        $this->response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

        return $this->response
            ->withHeader('Content-Type', 'application/json; charset=UTF-8')
            ->withStatus(201);
    }


    /**
     * Handles PUT request for updating a movie
     * 
     */
    public function put(): Response
    {
        $requestAttribute = $this->request->getAttribute('uid') ?? null;

        $this->validateRequestAttribute($requestAttribute);
        $this->validateResource($requestAttribute);

        $validatedData = $this->validateData();
        $result = $this->movieModel->updateMovie("movie_details", $validatedData, ['uid' => 'uid'], $requestAttribute);
        $response_code = $this->response->getStatusCode();

        if ($response_code !== 200) {
            $errorResponse = $this->errorResponse($this->response->getReasonPhrase(), 'Cannot modify resource', (bool) $result);
            $this->response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $this->response
                ->withHeader('Content-Type', 'application/json; charset=UTF-8')
                ->withStatus(500);
        }

        $successResponse = $this->successResponse($this->response->getReasonPhrase(), 'Resource modified successfully', (bool) $result);
        $this->response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

        return $this->response
            ->withHeader('Content-Type', 'application/json; charset=UTF-8')
            ->withStatus(200);
    }


    /**
     * Handles PATCH request for partially updating a movie
     * 
     */
    public function patch(): Response
    {
        $requestAttribute = $this->request->getAttribute('uid') ?? null;

        $this->validateRequestAttribute($requestAttribute);
        $this->validateResource($requestAttribute);

        $validatedData = $this->validateData();
        $result = $this->movieModel->updateMovie("movie_details", $validatedData, ['uid' => 'uid'], $requestAttribute);
        $response_code = $this->response->getStatusCode();

        if ($response_code !== 200) {
            $errorResponse = $this->errorResponse($this->response->getReasonPhrase(), 'Cannot modify resource', (bool) $result);
            $this->response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $this->response
                ->withHeader('Content-Type', 'application/json; charset=UTF-8')
                ->withStatus(500);
        }

        $successResponse = $this->successResponse($this->response->getReasonPhrase(), 'Resource modified successfully', (bool) $result);
        $this->response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

        return $this->response
            ->withHeader('Content-Type', 'application/json; charset=UTF-8')
            ->withStatus(200);
    }


    /**
     * Handles DELETE request for deleting a movie
     * 
     */
    public function delete(): Response
    {
        $requestAttribute = $this->request->getAttribute('uid') ?? null;

        $this->validateRequestAttribute($requestAttribute);
        $this->validateResource($requestAttribute);

        $result = $this->movieModel->deleteMovie("movie_details", ['uid' => 'uid'], $requestAttribute);
        $response_code = $this->response->getStatusCode();

        if ($response_code !== 200) {
            $errorResponse = $this->errorResponse($this->response->getReasonPhrase(), 'Cannot delete resource', (bool) $result);
            $this->response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $this->response
                ->withHeader('Content-Type', 'application/json; charset=UTF-8')
                ->withStatus(500);
        }

        $successResponse = $this->successResponse($this->response->getReasonPhrase(), 'Resource deleted successfully', (bool) $result);
        $this->response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

        return $this->response
            ->withHeader('Content-Type', 'application/json; charset=UTF-8')
            ->withStatus(200);
    }


    /**
     * Handles GET request for fetching movies based on selection
     * 
     */
    public function getSelection(): Response
    {
        $numberPerPage = $this->request->getAttribute('numberPerPage') ?? null;

        $this->validateRequestAttribute($numberPerPage);

        $result = $this->movieModel->retrieveAllMovies("movie_details");
        $response_code = $this->response->getStatusCode();

        if ($response_code !== 200) {
            $errorResponse = $this->errorResponse($this->response->getReasonPhrase(), 'Cannot retrieve resource', $result);
            $this->response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $this->response
                ->withHeader('Content-Type', 'application/json; charset=UTF-8')
                ->withStatus(500);
        }

        $selection = array_slice($result, 0, $numberPerPage);
        $successResponse = $this->successResponse($this->response->getReasonPhrase(), 'Resource retrieved successfully', $selection);
        $this->response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

        return $this->response
            ->withHeader('Content-Type', 'application/json; charset=UTF-8')
            ->withStatus(200);
    }


    /**
     * Handles GET request for fetching sorted movies based on selection
     * 
     */
    public function getSortedSelection(): Response
    {
        $fieldToSort = $this->request->getAttribute('fieldToSort') ?? null;

        $validSortFields = ['uid', 'title', 'year', 'released', 'runtime', 'directors', 'actors', 'country', 'poster', 'imdb', 'type'];

        if (!in_array($fieldToSort, $validSortFields)) {
            $errorResponse = $this->errorResponse(
                "Bad request",
                "Provided field doesn't exist",
                [
                    "provided" => $fieldToSort,
                    "expected" => $validSortFields
                ]
            );

            $this->response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $this->response
                ->withHeader('Content-Type', 'application/json; charset=UTF-8')
                ->withStatus(400);
        }

        $this->validateRequestAttribute($fieldToSort);

        $this->getSelection();
    }
}
