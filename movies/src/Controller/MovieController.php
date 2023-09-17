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
    public function __construct(MovieModel $movieModel)
    {
        parent::__construct($movieModel);
    }


    /**
     * Handles GET request for fetching movies
     * 
     */
    public function get(Request $request, Response $response, $args): Response
    {
        // $numberPerPage = $args['numberPerPage'] ?? null;
        // $fieldToSort = $args['fieldToSort'] ?? null;

        $result = $this->movieModel->retrieveAllMovies("movie_details");

        if (!array($result)) {
            $errorResponse = $this->errorResponse('Internal Server Error', 'Cannot retrieve resource', $result);
            $response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $response
                ->withHeader('Content-Type', 'application/json; charset=UTF-8')
                ->withStatus(500);
        }

        $successResponse = $this->successResponse('OK', 'Resource retrieved successfully', $result);
        $response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

        return $response
            ->withHeader('Content-Type', 'application/json; charset=UTF-8')
            ->withStatus(200);
    }


    /**
     * Handles POST request for creating a movie
     *
     */
    public function post(Request $request, Response $response): Response
    {
        $validatedData = $this->validateData($request, $response);
        $result = $this->movieModel->createMovie("movie_details", $validatedData);

        if ($result !== true) {

            $errorResponse = $this->errorResponse('Internal Server Error', 'Cannot create resource', (bool) $result);
            $response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $response
                ->withHeader('Content-Type', 'application/json; charset=UTF-8')
                ->withStatus(500);
        }

        $successResponse = $this->successResponse('Request Successful', 'New Resource Created', (bool) $result);
        $response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

        return $response
            ->withHeader('Content-Type', 'application/json; charset=UTF-8')
            ->withStatus(201);
    }


    //     /**
    //      * Handles PUT request for updating a movie
    //      * 
    //      */
    //     public function put(Request $request, Response $response, $args): Response
    //     {
    //         $requestAttribute = $args['uid'] ?? null;

    //         $this->validateRequestAttribute($requestAttribute);
    //         $this->validateResource($requestAttribute);

    //         $validatedData = $this->validateData();
    //         $result = $this->movieModel->updateMovie("movie_details", $validatedData, ['uid' => 'uid'], $requestAttribute);
    //         $response_code = $response->getStatusCode();

    //         if ($response_code !== 200) {
    //             $errorResponse = $this->errorResponse($response->getReasonPhrase(), 'Cannot modify resource', (bool) $result);
    //             $response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

    //             return $response
    //                 ->withHeader('Content-Type', 'application/json; charset=UTF-8')
    //                 ->withStatus(500);
    //         }

    //         $successResponse = $this->successResponse($response->getReasonPhrase(), 'Resource modified successfully', (bool) $result);
    //         $response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

    //         return $response
    //             ->withHeader('Content-Type', 'application/json; charset=UTF-8')
    //             ->withStatus(200);
    //     }


    //     /**
    //      * Handles PATCH request for partially updating a movie
    //      * 
    //      */
    //     public function patch(Request $request, Response $response, $args): Response
    //     {
    //         $requestAttribute = $args['uid'] ?? null;

    //         $this->validateRequestAttribute($requestAttribute);
    //         $this->validateResource($requestAttribute);

    //         $validatedData = $this->validateData();
    //         $result = $this->movieModel->updateMovie("movie_details", $validatedData, ['uid' => 'uid'], $requestAttribute);
    //         $response_code = $response->getStatusCode();

    //         if ($response_code !== 200) {
    //             $errorResponse = $this->errorResponse($response->getReasonPhrase(), 'Cannot modify resource', (bool) $result);
    //             $response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

    //             return $response
    //                 ->withHeader('Content-Type', 'application/json; charset=UTF-8')
    //                 ->withStatus(500);
    //         }

    //         $successResponse = $this->successResponse($response->getReasonPhrase(), 'Resource modified successfully', (bool) $result);
    //         $response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

    //         return $response
    //             ->withHeader('Content-Type', 'application/json; charset=UTF-8')
    //             ->withStatus(200);
    //     }


    //     /**
    //      * Handles DELETE request for deleting a movie
    //      * 
    //      */
    //     public function delete(Request $request, Response $response, $args): Response
    //     {
    //         $requestAttribute = $args['uid'] ?? null;

    //         $this->validateRequestAttribute($requestAttribute);
    //         $this->validateResource($requestAttribute);

    //         $result = $this->movieModel->deleteMovie("movie_details", ['uid' => 'uid'], $requestAttribute);
    //         $response_code = $response->getStatusCode();

    //         if ($response_code !== 200) {
    //             $errorResponse = $this->errorResponse($response->getReasonPhrase(), 'Cannot delete resource', (bool) $result);
    //             $response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

    //             return $response
    //                 ->withHeader('Content-Type', 'application/json; charset=UTF-8')
    //                 ->withStatus(500);
    //         }

    //         $successResponse = $this->successResponse($response->getReasonPhrase(), 'Resource deleted successfully', (bool) $result);
    //         $response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

    //         return $response
    //             ->withHeader('Content-Type', 'application/json; charset=UTF-8')
    //             ->withStatus(200);
    //     }


    //     /**
    //      * Handles GET request for fetching movies based on selection
    //      * 
    //      */
    //     public function getSelection(Request $request, Response $response, $args): Response
    //     {
    //         $numberPerPage = $args['numberPerPage'] ?? null;

    //         $this->validateRequestAttribute($numberPerPage);

    //         $result = $this->movieModel->retrieveAllMovies("movie_details");
    //         $response_code = $response->getStatusCode();

    //         if ($response_code !== 200) {
    //             $errorResponse = $this->errorResponse($response->getReasonPhrase(), 'Cannot retrieve resource', $result);
    //             $response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

    //             return $response
    //                 ->withHeader('Content-Type', 'application/json; charset=UTF-8')
    //                 ->withStatus(500);
    //         }

    //         $selection = array_slice($result, 0, $numberPerPage);
    //         $successResponse = $this->successResponse($response->getReasonPhrase(), 'Resource retrieved successfully', $selection);
    //         $response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

    //         return $response
    //             ->withHeader('Content-Type', 'application/json; charset=UTF-8')
    //             ->withStatus(200);
    //     }


    //     /**
    //      * Handles GET request for fetching sorted movies based on selection
    //      * 
    //      */
    //     public function getSortedSelection(Request $request, Response $response, $args): Response
    //     {
    //         $fieldToSort = $args['fieldToSort'] ?? null;

    //         $validSortFields = ['uid', 'title', 'year', 'released', 'runtime', 'directors', 'actors', 'country', 'poster', 'imdb', 'type'];

    //         if (!in_array($fieldToSort, $validSortFields)) {
    //             $errorResponse = $this->errorResponse(
    //                 "Bad request",
    //                 "Provided field doesn't exist",
    //                 [
    //                     "provided" => $fieldToSort,
    //                     "expected" => $validSortFields
    //                 ]
    //             );

    //             $response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

    //             return $response
    //                 ->withHeader('Content-Type', 'application/json; charset=UTF-8')
    //                 ->withStatus(400);
    //         }

    //         $this->validateRequestAttribute($fieldToSort);
    //     }
}
