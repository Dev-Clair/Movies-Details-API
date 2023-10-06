<?php

declare(strict_types=1);

namespace src\Controller;

use Slim\Psr7\Response as Response;
use Slim\Psr7\Request as Request;
use src\Model\MovieModel;
use OpenApi\Annotations as OA;
use src\Interface\ControllerInterface;
use src\Trait\Response_200_Trait as Response_200;
use src\Trait\Response_201_Trait as Response_201;
use src\Trait\Response_400_Trait as Response_400;
use src\Trait\Response_404_Trait as Response_404;
use src\Trait\Response_422_Trait as Response_422;
use src\Trait\Response_500_Trait as Response_500;


/**
 * @OA\Info(
 *   title="Movies Detail API",
 *   version="1.0.0",
 *   description="API for managing movie details",
 * )
 */
class MovieController extends AbsController implements ControllerInterface
{
    use Response_200;
    use Response_201;
    use Response_400;
    use Response_404;
    use Response_422;
    use Response_500;

    protected MovieModel $movieModel;

    public function __construct()
    {
        $movieModel = new MovieModel();
        parent::__construct($movieModel);
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
            'API Welcome Message' => "Hello there!, Welcome to movies_detail API",
            'API Status' => 'Active',
            'API Endpoints' => [
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
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
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
        $this->validateData();

        if (!empty($this->cache['errors'])) {
            return $this->response_422('Not Successful', $this->cache['errors']);
            // Clear Cache
            $this->clearCache();
        }

        $resource = $this->movieModel->createMovie("movie_details", $this->cache['valid']);

        if ($resource === true) {
            // Clear Cache
            $this->clearCache();
            return $this->response_201('Successful', $resource);
        }

        return $this->response_500('Cannot create resource', $resource);
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
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationErrorResponse")
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

        $sanitizedData = $this->sanitizeData();;

        if (empty($sanitizedData)) {

            $this->clearCache();
            return $this->response_422('Not Successful', $sanitizedData);
        }

        if (!$this->movieModel->validateMovie("movie_details", ['uid' => 'uid'], htmlspecialchars($requestAttribute))) {
            return $this->response_404('Resource does not exist for supplied uid', $requestAttribute);
        }

        $resource = $this->movieModel->updateMovie("movie_details", $sanitizedData, ['uid' => 'uid'], htmlspecialchars($requestAttribute));

        if ($resource === true) {

            $this->clearCache();
            return $this->response_200('Resource modified successfully', $resource);
        }

        return $this->response_500('Cannot modify resource', $resource);
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
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationErrorResponse")
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

        $sanitizedData = $this->sanitizeData();;

        if (empty($sanitizedData)) {

            $this->clearCache();
            return $this->response_422('Not Successful', $sanitizedData);
        }

        if (!$this->movieModel->validateMovie("movie_details", ['uid' => 'uid'], htmlspecialchars($requestAttribute))) {
            return $this->response_404('Resource does not exist for supplied uid', $requestAttribute);
        }

        $resource = $this->movieModel->updateMovie("movie_details", $sanitizedData, ['uid' => 'uid'], htmlspecialchars($requestAttribute));

        if ($resource === true) {

            $this->clearCache();
            return $this->response_200('Resource modified successfully', $resource);
        }

        return $this->response_500('Cannot modify resource', $resource);
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
     *         response=404,
     *         description="Not Found",
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

        if (!$this->movieModel->validateMovie("movie_details", ['uid' => 'uid'], htmlspecialchars($requestAttribute))) {
            return $this->response_404('Resource does not exist for supplied uid', $requestAttribute);
        }

        $resource = $this->movieModel->deleteMovie("movie_details", ['uid' => 'uid'], htmlspecialchars($requestAttribute));

        if ($resource === true) {

            return $this->response_200('Resource deleted successfully', $resource);
        };
        return $this->response_500('Cannot delete resource', $resource);
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
        $numberPerPage = (int) $args['numberPerPage'] ?? 10;

        $resource = $this->movieModel->retrieveAllMovies("movie_details");

        if (!array($resource)) {

            return $this->response_500('Cannot retrieve resource', $resource);
        }

        return $this->response_200('Resource retrieved successfully', array_slice($resource, 0, $numberPerPage, true));
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
        $numberPerPage = (int) $args['numberPerPage'] ?? 10;
        $fieldToSort = (string) $args['fieldToSort'] ?? 'uid';

        $resource = $this->movieModel->sortMovie("movie_details", $fieldToSort);

        if (!array($resource)) {

            return $this->response_500('Cannot retrieve resource', $resource);
        }

        return $this->response_200('Resource retrieved successfully', array_slice($resource, 0, $numberPerPage, true));
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

            return $this->response_500('Cannot retrieve resource', $resource);
        }

        return $this->response_200('Similar results found for: ' . $title, $resource);
    }
}
