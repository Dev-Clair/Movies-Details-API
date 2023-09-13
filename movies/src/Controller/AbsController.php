<?php

declare(strict_types=1);

namespace src\Controller;

use src\Model\MovieModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Abstract Controller Class
 * 
 * Provides helper methods to child class methods
 * 
 * @var MovieModel $movieModel
 * @var Request $request
 * @var Response $response
 * 
 */
abstract class AbsController implements IntController
{
    protected MovieModel $movieModel;

    public function __construct(MovieModel $movieModel, protected Request $request, protected Response $response)
    {
        $this->movieModel = new $movieModel;
    }

    protected function validateRequestAttribute($requestAttribute): Response
    {
        // Check if attribute is not null
        if (is_null($requestAttribute)) {
            $errorResponse = $this->errorResponse(
                'Bad Request',
                'Cannot retrieve attribute',
                ['missing' =>
                [
                    'attribute' => $requestAttribute
                ]]
            );
            $this->response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $this->response
                ->withHeader('Content-Type', 'application/json; charset=UTF-8')
                ->withStatus(400);
        }
    }

    protected function validateResource($requestAttribute): Response
    {
        // Check if resource exists on the server
        $result = $this->movieModel->validateMovie("movie_details", ['uid' => 'uid'], htmlspecialchars($requestAttribute));

        if (!$result) {
            $errorResponse = $this->errorResponse(
                'Bad Request',
                'No resource found for attribute {$requestAttribute} on the server',
                $result
            );
            $this->response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $this->response
                ->withHeader('Content-Type', 'application/json; charset=UTF-8')
                ->withStatus(400);
        }
    }

    protected function errorResponse(array|string $response, array|string $message, bool|array|string|null $data): array
    {
        $errorResponse = [
            'error' =>   $response,
            'message' => $message,
            'data' => $data
        ];

        return $errorResponse;
    }

    protected function successResponse(array|string $response, array|string $message, bool|array|string|null $data): array
    {
        $successResponse = [
            'success' =>   $response,
            'message' => $message,
            'data' => $data
        ];

        return $successResponse;
    }

    protected function sanitizeData(): array
    {
        $sanitizedData = [];

        $postData =  $this->request->getServerParams(); // json_decode(file_get_contents('php://input'), true);
        foreach ($postData as $postField => $postValue) {
            $sanitizedData[$postField] = filter_var($postValue, FILTER_SANITIZE_SPECIAL_CHARS);
        }
        return $sanitizedData;
    }

    protected function validateData(): array
    {
        $errors = [];
        $validatedData = [];
        $sanitizedData = $this->sanitizeData();

        // Movie ID Field
        $pattern = '/^\/mv[\d]{3,4}\/$/';
        $uid = $sanitizedData['uid'] ?? null;
        if (preg_match($pattern, $uid)) {
            $validatedData['uid'] = $uid;
        } else {
            $errors['uid'] = 'Please pass a valid movie unique id';
        }

        // Movie Title Field
        $title = $sanitizedData['title'] ?? null;
        if (!empty($title)) {
            $validatedData['title'] = $title;
        } else {
            $errors['title'] = 'Please pass a valid movie title';
        }

        // Movie Year Field
        $year = $sanitizedData['year'] ?? null;
        if (is_numeric($year)) {
            $validatedData['year'] = (int) $year;
        } else {
            $errors['year'] = 'Please pass a valid movie year';
        }

        // Movie Release Date Field 
        $released = $sanitizedData['released'] ?? null;
        if (strtotime($released) !== false) {
            $validatedData['released'] = $released;
        } else {
            $errors['released'] = 'Please pass a valid movie release date: YYYY-MM-DD';
        }

        // Movie Runtime Field
        $runtime = $sanitizedData['runtime'] ?? null;
        if (is_numeric($runtime)) {
            $validatedData['runtime'] = (string) $runtime . ' mins';
        } else {
            $errors['runtime'] = 'Please pass a valid movie runtime';
        }

        // Movie Directors Field
        $directors = $sanitizedData['directors'] ?? null;
        if (!empty($directors)) {
            $validatedData['directors'] = explode(',', $directors);
        } else {
            $errors['directors'] = 'Please pass valid movie director name(s)';
        }

        // Movie Actors Field
        $actors = $sanitizedData['actors'] ?? null;
        if (!empty($actors)) {
            $validatedData['actors'] = explode(',', $actors);
        } else {
            $errors['actors'] = 'Please pass valid movie actor name(s)';
        }

        // Movie Country Field
        $country = $sanitizedData['country'] ?? null;
        if (!empty($country)) {
            $validatedData['country'] = $country;
        } else {
            $errors['country'] = 'Please pass a valid movie country';
        }

        // Movie Poster Field
        $poster = $sanitizedData['poster'] ?? null;
        if (is_string($poster)) {
            $validatedData['poster'] = $poster;
        }
        $validatedData['poster'] = "";

        // Movie IMDB Field
        $imdb = $sanitizedData['imdb'] ?? null;
        if (filter_var($imdb, FILTER_VALIDATE_FLOAT) !== false) {
            $validatedData['imdb'] = (string) $imdb;
        } else {
            $errors['imdb'] = 'Please pass a valid movie rating';
        }

        // Movie Type Field
        $type = $sanitizedData['type'] ?? null;
        if (!empty($type)) {
            $validatedData['type'] = $type;
        } else {
            $errors['type'] = 'Please pass a valid movie type';
        }

        if (!empty($errors)) {
            $expected = [
                'uid' => "movie_unique_id: mv000 or mv0000",
                'title' => 'movie_title',
                'year' => 'movie_year: YYYY',
                'released' => 'movie_release_date: YYYY-MM-DD',
                'runtime' => 'movie_runtime: 00 mins',
                'directors' => 'movie_directors',
                'actors' => 'movie_actors',
                'country' => 'movie_country',
                'poster' => '',
                'imdb' => 'movie_rating',
                'type' => 'movie_genre'
            ];
            $errorResponse = [
                'error' => 'Unprocessable Entity',
                'message' => 'Invalid Entries',
                'expected' => $expected,
                'supplied' => $errors,
            ];
            $this->response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $this->response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(422);
        }

        return $validatedData;
    }
}
