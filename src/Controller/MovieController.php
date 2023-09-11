<?php

declare(strict_types=1);

namespace src\Controller;

use src\Model\MovieModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;


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
    private MovieModel $movieModel;

    public function __construct(MovieModel $movieModel, Request $request, Response $response)
    {
        $this->movieModel = new $movieModel;
        parent::__construct($request, $response);
    }

    // /**
    //  * Checks if a request method is allowed for an endpoint
    //  * 
    //  * Returns http error response on failure or void on success
    //  */
    // private function methodType(string $method, array $allowed): Response
    // {
    //     $methodType = $this->request->getMethod();

    //     if ($methodType !== $method) {
    //         $errorResponse = $this->errorResponse('Invalid Request Method', 'This endpoint does not allow for this request method.', $methodType);
    //         $this->response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

    //         return $this->response
    //             ->withHeader('Allow', implode(",", $allowed))
    //             ->withStatus(400);
    //     }
    // }

    // /**
    //  * Checks GET/POST/PUT/PATCH/DELETE request header for json content-type
    //  * 
    //  * Returns http error response on failure or void on success
    //  */
    // private function contentType(): Response
    // {
    //     $contentType = $this->request->getHeaderLine('Content-Type');

    //     if (strpos($contentType, 'application/json') === false) {
    //         $errorResponse = $this->errorResponse('Invalid Content-Type', 'This endpoint requires a JSON Content-Type header.', $contentType);
    //         $this->response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

    //         return $this->response
    //             ->withHeader('Content-Type', 'application/json')
    //             ->withStatus(400);
    //     }
    // }

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
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);
        }

        $successResponse = $this->successResponse($this->response->getReasonPhrase(), 'Resource retrieved successfully', $result);
        $this->response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    /**
     * Handles POST request for creating a movie
     *
     */
    public function post(): Response
    {
        $result = $this->movieModel->createMovie("movie_details", []);
        $response_code = $this->response->getStatusCode();

        if ($response_code !== 201) {

            $errorResponse = $this->errorResponse($this->response->getReasonPhrase(), 'Cannot create resource', (bool) $result);
            $this->response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $this->response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);
        }

        $successResponse = $this->successResponse($this->response->getReasonPhrase(), 'Resource created successfully', (bool) $result);
        $this->response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }

    /**
     * Handles PUT request for updating a movie
     * 
     */
    public function put(): Response
    {
        $fieldValue = $this->request->getAttribute('uid') ?? null;

        $validatedData = $this->validateData();
        $result = $this->movieModel->updateMovie("movie_details", $validatedData, 'uid', $fieldValue);
        $response_code = $this->response->getStatusCode();

        if ($response_code !== 200) {
            $errorResponse = $this->errorResponse($this->response->getReasonPhrase(), 'Cannot modify resource', (bool) $result);
            $this->response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $this->response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);
        }

        $successResponse = $this->successResponse($this->response->getReasonPhrase(), 'Resource modify successfully', (bool) $result);
        $this->response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }


    /**
     * Handles PATCH request for partially updating a movie
     * 
     */
    public function patch(): Response
    {
        $fieldValue = $this->request->getAttribute('uid') ?? null;

        $validatedData = $this->validateData();
        $result = $this->movieModel->updateMovie("movie_details", $validatedData, 'uid', $fieldValue);
        $response_code = $this->response->getStatusCode();

        if ($response_code !== 200) {
            $errorResponse = $this->errorResponse($this->response->getReasonPhrase(), 'Cannot modify resource', (bool) $result);
            $this->response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $this->response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);
        }

        $successResponse = $this->successResponse($this->response->getReasonPhrase(), 'Resource modify successfully', (bool) $result);
        $this->response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }


    /**
     * Handles DELETE request for deleting a movie
     * 
     */
    public function delete(): Response
    {
        $fieldValue = $this->request->getAttribute('uid') ?? null;

        $result = $this->movieModel->deleteMovie("movie_details", 'uid', $fieldValue);
        $response_code = $this->response->getStatusCode();

        if ($response_code !== 200) {
            $errorResponse = $this->errorResponse($this->response->getReasonPhrase(), 'Cannot delete resource', (bool) $result);
            $this->response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $this->response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);
        }

        $successResponse = $this->successResponse($this->response->getReasonPhrase(), 'Resource deleted successfully', (bool) $result);
        $this->response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    /**
     * Handles GET request for fetching movies based on selection
     * 
     */
    public function getSelection(): Response
    {
        $fieldValue = $this->request->getAttribute('numberPerPage') ?? null;

        $result = $this->movieModel->retrieveSelection("movie_details", 'numberPerPage', $fieldValue);
        $response_code = $this->response->getStatusCode();

        if ($response_code !== 200) {
            $errorResponse = $this->errorResponse($this->response->getReasonPhrase(), 'Cannot retrieve resource', $result);
            $this->response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $this->response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);
        }

        $successResponse = $this->successResponse($this->response->getReasonPhrase(), 'Resource retrieved successfully', $result);
        $this->response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    /**
     * Handles GET request for fetching sorted movies based on selection
     * 
     */
    public function getSortedSelection(): Response
    {
        $numberPerPage = $this->request->getAttribute('numberPerPage') ?? null;
        $fieldToSort = $this->request->getAttribute('fieldToSort') ?? null;

        $result = $this->movieModel->retrieveSelection("movie_details", 'numberPerPage', $numberPerPage, $fieldToSort);
        $response_code = $this->response->getStatusCode();

        if ($response_code !== 200) {
            $errorResponse = $this->errorResponse($this->response->getReasonPhrase(), 'Cannot retrieve resource', $result);
            $this->response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $this->response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);
        }

        $successResponse = $this->successResponse($this->response->getReasonPhrase(), 'Resource retrieved successfully', $result);
        $this->response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
