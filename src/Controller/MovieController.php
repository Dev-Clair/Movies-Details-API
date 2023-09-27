<?php

declare(strict_types=1);

namespace src\Controller;

// Slim Psr Implementation
use Slim\Psr7\Response as Response;
use Slim\Psr7\Request as Request;
// Controller Class Dependency
use src\Model\MovieModel;
// Custom Exception
use src\Exception\InvalidMethodCallException;
// OpenApi Annotations
use OpenApi\Annotations as OA;

// Custom Response Messages
use src\Trait\Response_200_Trait as Response_200;
use src\Trait\Response_201_Trait as Response_201;
use src\Trait\Response_400_Trait as Response_400;
use src\Trait\Response_405_Trait as Response_405;
use src\Trait\Response_422_Trait as Response_422;
use src\Trait\Response_500_Trait as Response_500;


/**
 * @OA\Info(
 *   title="Movies Detail API",
 *   version="1.0.0",
 *   description="API for managing movie details",
 * )
 */
class MovieController extends AbsController
{
    use Response_200;
    use Response_201;
    use Response_400;
    use Response_405;
    use Response_422;
    use Response_500;

    public function __construct()
    {
        /**
         * @var MovieModel $movieModel
         */
        $movieModel = new MovieModel(databaseName: "movies");
        parent::__construct($movieModel);
    }

    public function __call(string $name, array $arguments)
    {
        if (method_exists(MovieController::class, $name)) {
            call_user_func_array([MovieController::class, $name], $arguments);
        }
        throw new InvalidMethodCallException("Call to undefined method " . $name);
    }
    /**
     * @OA\Schema(
     *     schema="ErrorResponse",
     *     @OA\Property(property="message", type="string", example="Bad Request"),
     *     @OA\Property(property="description", type="string", example="Cannot modify resource"),
     *     @OA\Property(property="error", type="string", example="Invalid Entry: {requestAttribute}")
     * )
     *
     * @OA\Schema(
     *     schema="SuccessResponse",
     *     @OA\Property(property="status", type="string", example="OK"),
     *     @OA\Property(property="message", type="string", example="Resource validation successful"),
     *     @OA\Property(property="data", type="string", example="Resource validated successfully")
     * )
     */

    /**
     * Validate the request attribute and resource existence.
     *
     * @param Response $response The HTTP response instance.
     * @param mixed $requestAttribute The request attribute to validate.
     *
     * @return Response|null Returns a response with error details if validation fails, or null if validation is successful.
     *
     *
     * @OA\Parameter(
     *     name="requestAttribute",
     *     in="query",
     *     required=true,
     *     description="The request attribute to validate.",
     *     @OA\Schema(type="string")
     * )
     * @OA\Response(
     *     response=200,
     *     description="Resource validated successfully",
     *     @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     * )
     * @OA\Response(
     *     response=400,
     *     description="Bad Request",
     *     @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     * )
     */
    protected function validateRequestAtrribute(Response $response, $requestAttribute): Response|null
    {
        $validationCache = [];

        $validationCache['validateRequestAtrribute'] = $this->validateAttribute($requestAttribute);
        $validationCache['validateResource'] = $this->validateResource($requestAttribute);

        if ($validationCache['validateRequestAtrribute'] === true) {

            return $this->response_400('Cannot modify resource', 'Invalid Entry: ' . $requestAttribute);
        }

        if ($validationCache['validateResource'] === false) {

            return $this->response_400(
                'Cannot modify resource',
                'No matching unique id found for: ' . $requestAttribute
            );
        }

        return null;
    }


    /**
     * @OA\Get(
     *     path="/v1",
     *     tags={"API Info"},
     *     summary="Get API information",
     *     description="Returns information about the API and available endpoints.",
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(ref="#/components/schemas/ApiInfoResponse")
     *     ),
     * )
     */
    public function getAPIInfo(Request $request, Response $response, array $args): Response
    {
        $api_info = [
            'message' => "Hello there!, Welcome to movies_detail API",
            'status' => 'Active',
            'endpoints' => [
                'GET' => '/v1/movies',
                'POST' => '/v1/movies',
                'PUT' => '/v1/movies/{uid}',
                'DELETE' => '/v1/movies/{uid}',
                'PATCH' => '/v1/movies/{uid}',
                'GET' => '/v1/movies/{numberPerPage}',
                'GET' => '/v1/movies/{numberPerPage}/sort/{fieldToSort}',
                'GET' => '/v1/movies/search/{title}'
            ]
        ];

        return $this->response_200('Successful', $api_info);
    }


    /**
     * @OA\Get(
     *     path="/v1/movies",
     *     tags={"Movies"},
     *     summary="Get a list of movies",
     *     description="Returns a list of movies.",
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(ref="#/components/schemas/MovieListResponse")
     *     ),
     * )
     */
    public function get(Request $request, Response $response, array $args): Response
    {
        $resource = $this->movieModel->retrieveAllMovies("movie_details");

        if (!array($resource)) {

            return $this->response_500('Cannot retrieve resource', $resource);
        }

        return $this->response_200('Resource retrieved successfully', $resource);
    }


    /**
     * @OA\Post(
     *     path="/v1/movies",
     *     tags={"Movies"},
     *     summary="Create a new movie",
     *     description="Creates a new movie record with the provided data.",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Movie data",
     *         @OA\JsonContent(ref="#/components/schemas/NewMovieData")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Movie created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     * )
     */
    public function post(Request $request, Response $response, array $args): Response
    {
        $this->validateData($request, $response);

        $validDataCache = [];

        $invalidDataCache = [];

        if (!empty($invalidDataCache)) {

            return $this->response_422('Not Successful', $invalidDataCache);
            // Clear Cache
            "Clear Cache";
        }

        $resource = $this->movieModel->createMovie("movie_details", $validDataCache);

        if ($resource) {

            return $this->response_201('Successful', (bool) $resource);
            // Clear Cache
            "Clear Cache";
        }

        return $this->response_500('Cannot create resource', (bool) $resource);
    }


    /**
     * @OA\Put(
     *     path="/v1/movies/{uid}",
     *     tags={"Movies"},
     *     summary="Update a movie",
     *     description="Update an entire movie based on provided reference data parameter.",
     *     @OA\Parameter(
     *         name="uid",
     *         in="path",
     *         required=true,
     *         description="Unique ID of the movie to update.",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Updated movie data",
     *         @OA\JsonContent(ref="#/components/schemas/UpdatedMovieData")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Movie updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     * )
     */
    public function put(Request $request, Response $response, array $args): Response
    {
        $requestAttribute = (string) $args['uid'] ?? null;

        $this->validateRequestAtrribute($response, $requestAttribute);

        $sanitizedData = $this->sanitizeData();

        if (empty($sanitizedData)) {

            $errorResponse = $this->errorResponse('Unprocessable Entity', 'Cannot modify resource', [
                'message' => 'Invalid Entries',
                'data' => $sanitizedData,
            ]);

            $response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $response
                ->withHeader('Content-Type', 'application/json; charset=UTF-8')
                ->withStatus(422);
        }

        $resource = $this->movieModel->updateMovie("movie_details", $sanitizedData, ['uid' => 'uid'], htmlspecialchars($requestAttribute));

        $successResponse = $this->successResponse('OK', 'Resource modified successfully', (bool) $resource);
        $response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

        return $response
            ->withHeader('Content-Type', 'application/json; charset=UTF-8')
            ->withStatus(200);
    }


    /**
     * @OA\Patch(
     *     path="/v1/movies/{uid}",
     *     tags={"Movies"},
     *     summary="Update specified section of a movie based on provided reference data parameter",
     *     description="Updates a movie record with the provided data.",
     *     @OA\Parameter(
     *         name="uid",
     *         in="path",
     *         required=true,
     *         description="Unique ID of the movie to update.",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Updated movie data",
     *         @OA\JsonContent(ref="#/components/schemas/UpdatedMovieData")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Movie updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     * )
     */
    public function patch(Request $request, Response $response, array $args): Response
    {
        $requestAttribute = (string) $args['uid'] ?? null;

        $this->validateRequestAtrribute($response, $requestAttribute);

        $sanitizedData = $this->sanitizeData();

        if (empty($sanitizedData)) {

            $errorResponse = $this->errorResponse('Unprocessable Entity', 'Cannot modify resource', [
                'message' => 'Invalid Entries',
                'data' => $sanitizedData,
            ]);

            $response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $response
                ->withHeader('Content-Type', 'application/json; charset=UTF-8')
                ->withStatus(422);
        }

        $resource = $this->movieModel->updateMovie("movie_details", $sanitizedData, ['uid' => 'uid'], htmlspecialchars($requestAttribute));

        $successResponse = $this->successResponse('OK', 'Resource modified successfully', (bool) $resource);
        $response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

        return $response
            ->withHeader('Content-Type', 'application/json; charset=UTF-8')
            ->withStatus(200);
    }


    /**
     * @OA\Delete(
     *     path="/v1/movies/{uid}",
     *     tags={"Movies"},
     *     summary="Delete a movie",
     *     description="Deletes a movie record with the specified UID.",
     *     @OA\Parameter(
     *         name="uid",
     *         in="path",
     *         required=true,
     *         description="Unique ID of the movie to delete.",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Movie deleted successfully",
     *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     * )
     */
    public function delete(Request $request, Response $response, array $args): Response
    {
        $requestAttribute = (string) $args['uid'] ?? null;

        $this->validateRequestAtrribute($response, $requestAttribute);

        $resource = $this->movieModel->deleteMovie("movie_details", ['uid' => 'uid'], htmlspecialchars($requestAttribute));

        if ((bool)$resource !== true) {
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
     * @OA\Get(
     *     path="/v1/movies/{numberPerPage}",
     *     tags={"Movies"},
     *     summary="Get a selection of movies",
     *     description="Fetches a selection of movies based on the number per page.",
     *     @OA\Parameter(
     *         name="numberPerPage",
     *         in="path",
     *         required=true,
     *         description="Number of movies per page.",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Movies retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     * )
     */
    public function getSelection(Request $request, Response $response, array $args): Response
    {
        $numberPerPage = (int) $args['numberPerPage'] ?? 7;

        $resource = $this->movieModel->retrieveAllMovies("movie_details");

        if (!array($resource)) {
            $errorResponse = $this->errorResponse('Internal server error', 'Cannot retrieve resource', $resource);
            $response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $response
                ->withHeader('Content-Type', 'application/json; charset=UTF-8')
                ->withStatus(500);
        }

        $successResponse = $this->successResponse('OK', 'Resource retrieved successfully', array_slice($resource, 0, $numberPerPage, true));
        $response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

        return $response
            ->withHeader('Content-Type', 'application/json; charset=UTF-8')
            ->withStatus(200);
    }


    /**
     * @OA\Get(
     *     path="/v1/movies/{numberPerPage}/sort/{fieldToSort}",
     *     tags={"Movies"},
     *     summary="Get a sorted selection of movies",
     *     description="Fetches a sorted selection of movies based on the number per page and field to sort.",
     *     @OA\Parameter(
     *         name="numberPerPage",
     *         in="path",
     *         required=true,
     *         description="Number of movies per page.",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="fieldToSort",
     *         in="path",
     *         required=false,
     *         description="Field to sort by (default: uid).",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Movies retrieved and sorted successfully",
     *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     * )
     */
    public function getSortedSelection(Request $request, Response $response, array $args): Response
    {
        $numberPerPage = (int) $args['numberPerPage'] ?? 7;
        $fieldToSort = (string) $args['fieldToSort'] ?? 'uid';

        $resource = $this->movieModel->sortMovie("movie_details", $fieldToSort);

        if (!array($resource)) {
            $errorResponse = $this->errorResponse('Internal server error', 'Cannot retrieve resource', $resource);
            $response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $response
                ->withHeader('Content-Type', 'application/json; charset=UTF-8')
                ->withStatus(500);
        }

        $successResponse = $this->successResponse('OK', 'Resource retrieved successfully', array_slice($resource, 0, $numberPerPage, true));
        $response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

        return $response
            ->withHeader('Content-Type', 'application/json; charset=UTF-8')
            ->withStatus(200);
    }


    /**
     * @OA\Get(
     *     path="/v1/movies/search/{title}",
     *     tags={"Movies"},
     *     summary="Search for movies by title",
     *     description="Searches for movies based on the title.",
     *     @OA\Parameter(
     *         name="title",
     *         in="path",
     *         required=true,
     *         description="Title to search for.",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Movies found based on the title",
     *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     * )
     */
    public function getSearch(Request $request, Response $response, array $args): Response
    {
        $title =  (string) $args['title'];

        $resource = $this->movieModel->searchMovie("movie_details", ['title' => $title], $title);

        if (!array($resource)) {
            $errorResponse = $this->errorResponse('Internal server error', 'Cannot retrieve resource', $resource);
            $response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $response
                ->withHeader('Content-Type', 'application/json; charset=UTF-8')
                ->withStatus(500);
        }

        $successResponse = $this->successResponse('OK', 'Similar results found for: ' . $title, $resource);
        $response->getBody()->write(json_encode($successResponse, JSON_PRETTY_PRINT));

        return $response
            ->withHeader('Content-Type', 'application/json; charset=UTF-8')
            ->withStatus(200);
    }
}
