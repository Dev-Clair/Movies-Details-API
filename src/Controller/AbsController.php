<?php

declare(strict_types=1);

namespace src\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

abstract class AbsController implements IntController
{
    public function __construct(protected Request $request, protected Response $response)
    {
    }

    protected function errorResponse(string $response, string $message, bool|array|string $data): array
    {
        $errorResponse = [
            'error' =>   $response,
            'message' => $message,
            'data' => $data
        ];

        return $errorResponse;
    }

    protected function successResponse(string $response, ?string $message, bool|array|string $data): array
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
        if (!empty($poster)) {
            $validatedData['poster'] = $poster;
        } else {
            $errors['poster'] = 'Please pass a valid movie poster string';
        }

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
            $errorResponse = $this->errorResponse($this->response->getReasonPhrase(), 'Unprocessable Entity', $errors);
            $this->response->getBody()->write(json_encode($errorResponse, JSON_PRETTY_PRINT));

            return $this->response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(422);
        }

        return $validatedData;
    }
}
