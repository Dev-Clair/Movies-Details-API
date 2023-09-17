<?php

declare(strict_types=1);

namespace src\Controller;

use src\Model\MovieModel;


/**
 * Handles GET/POST/PUT/PATCH/DELETE request endpoints
 * 
 * @var MovieModel $movieModel
 * 
 */
class MovieController extends AbsController
{
    public function __construct(MovieModel $movieModel)
    {
        parent::__construct($movieModel);
    }


    /**
     * Handles GET request for fetching movies
     * 
     */
    public function get($args = []): string
    {
        $numberPerPage = $args['numberPerPage'] ?? null;
        $fieldToSort = $args['fieldToSort'] ?? null;

        $resource = $this->movieModel->retrieveAllMovies("movie_details");

        if (!array($resource)) {
            $errorResponse = $this->errorResponse('Internal Server Error', 'Cannot retrieve resource', $resource);
            $response = json_encode($errorResponse, JSON_PRETTY_PRINT);

            return $response;
        }

        $successResponse = $this->successResponse('OK', 'Resource retrieved successfully', $resource);
        $response = json_encode($successResponse, JSON_PRETTY_PRINT);

        return $response;
    }


    /**
     * Handles POST request for creating a movie
     *
     */
    public function post(): string
    {
        $validatedData = $this->validateData();
        $resource = $this->movieModel->createMovie("movie_details", $validatedData);

        if ($resource !== true) {

            $errorResponse = $this->errorResponse('Internal Server Error', 'Cannot create resource', (bool) $resource);
            $response = json_encode($errorResponse, JSON_PRETTY_PRINT);

            return $response;
        }

        $successResponse = $this->successResponse('Request Successful', 'New Resource Created', (bool) $resource);
        $response = json_encode($successResponse, JSON_PRETTY_PRINT);

        return $response;
    }


    /**
     * Handles PUT request for updating a movie
     * 
     */
    public function put($args): string
    {
        $requestAttribute = $args['uid'] ?? null;

        $this->validateRequestAttribute($requestAttribute);
        $this->validateResource($requestAttribute);

        $validatedData = $this->validateData();
        $resource = $this->movieModel->updateMovie("movie_details", $validatedData, ['uid' => 'uid'], $requestAttribute);

        if ($resource !== true) {
            $errorResponse = $this->errorResponse('Internal Server Error', 'Cannot modify resource', (bool) $resource);
            $response = json_encode($errorResponse, JSON_PRETTY_PRINT);

            return $response;
        }

        $successResponse = $this->successResponse('OK', 'Resource modified successfully', (bool) $resource);
        $response = json_encode($successResponse, JSON_PRETTY_PRINT);

        return $response;
    }


    /**
     * Handles PATCH request for partially updating a movie
     * 
     */
    public function patch($args = []): string
    {
        $requestAttribute = $args['uid'] ?? null;

        $this->validateRequestAttribute($requestAttribute);
        $this->validateResource($requestAttribute);

        $sanitizedData = $this->sanitizeData();
        $resource = $this->movieModel->updateMovie("movie_details", $sanitizedData, ['uid' => 'uid'], $requestAttribute);

        if ($resource !== true) {
            $errorResponse = $this->errorResponse('Internal Server Error', 'Cannot modify resource', (bool) $resource);
            $response = json_encode($errorResponse, JSON_PRETTY_PRINT);

            return $response;
        }

        $successResponse = $this->successResponse('OK', 'Resource modified successfully', (bool) $resource);
        $response = json_encode($successResponse, JSON_PRETTY_PRINT);

        return $response;
    }


    /**
     * Handles DELETE request for deleting a movie
     * 
     */
    public function delete($args = []): string
    {
        $requestAttribute = $args['uid'] ?? null;

        $this->validateRequestAttribute($requestAttribute);
        $this->validateResource($requestAttribute);

        $resource = $this->movieModel->deleteMovie("movie_details", ['uid' => 'uid'], $requestAttribute);


        if ($resource !== true) {
            $errorResponse = $this->errorResponse('Internal Server Error', 'Cannot delete resource', (bool) $resource);
            $response = json_encode($errorResponse, JSON_PRETTY_PRINT);

            return $response;
        }

        $successResponse = $this->successResponse('OK', 'Resource deleted successfully', (bool) $resource);
        $response = json_encode($successResponse, JSON_PRETTY_PRINT);

        return $response;
    }
}
