<?php

declare(strict_types=1);

namespace tests;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

/**
 * Test class for MovieController.
 * 
 * Extends PHPUnit\Framework\TestCase
 */
class MovieControllerTest extends TestCase
{
    private Client $http;

    /**
     * Set up the HTTP client before each test.
     */
    protected function setUp(): void
    {
        $this->http = new Client(['base_uri' => 'http://localhost:8888/']);
    }

    // protected function tearDown(): void
    // {
    //     $this->http = null;
    // }

    /**
     * Test the "get API Info" endpoint.
     */
    public function testGetAPIInfo(): void
    {
        $response = $this->http->request('GET', 'v1');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        $this->assertJson($response->getBody()->getContents());
    }

    /**
     * Test the "get" endpoint.
     */
    public function testGet(): void
    {
        $response = $this->http->request('GET', 'v1/movies');

        $contentType = $response->getHeaders()["Content-Type"][0];

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        $this->assertJson($response->getBody()->getContents());
    }

    /**
     * Test the "post" endpoint.
     */
    public function testPost(): void
    {
        $response = $this->http->request('POST', 'v1/movies', [
            'headers' => [
                'Content-Type' => 'application/json; charset=UTF-8',
            ],
            'body' => json_encode([
                "uid" => "mv7120",
                "title" => "The Covenant",
                "year" => "2023",
                "released" => "2023-05-21",
                "runtime" => "133 mins",
                "directors" => "Guy Ritchie",
                "actors" => "Jake Gyllenhaal, Dar Salim, Emily Beecham, Darunta Dam",
                "country" => "United States",
                "poster" => "https://example.com/poster_the_covenant.jpg",
                "imdb" => "7/10",
                "type" => "Action, Thriller"
            ]),
        ]);

        $contentType = $response->getHeaders()["Content-Type"][0];

        $this->assertEquals(201, $response->getStatusCode());

        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        $this->assertJson($response->getBody()->getContents());
    }

    /**
     * Test the "put" endpoint.
     */
    public function testPut(): void
    {
        $response = $this->http->request('PUT', 'v1/movies/mv7120', [
            'headers' => [
                'Content-Type' => 'application/json; charset=UTF-8',
            ],
            'body' => json_encode([
                "title" => "Guy Ritchie`s The Covenant",
                "year" => "2023",
                "released" => "2023-05-21",
                "runtime" => "120 mins",
                "directors" => "Guy Ritchie",
                "actors" => "Jake Gyllenhaal, Dar Salim, Emily Beecham, Darunta Dam, Alexander Ludwig",
                "country" => "United States",
                "poster" => "https://example.com/poster_guy_ritchie`s_the_covenant.jpg",
                "imdb" => "8/10",
                "type" => "Action, Thriller"
            ]),
        ]);

        $contentType = $response->getHeaders()["Content-Type"][0];

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        $this->assertJson($response->getBody()->getContents());
    }

    /**
     * Test the "patch" endpoint.
     */
    public function testPatch(): void
    {
        $response = $this->http->request('PATCH', 'v1/movies/mv7120', [
            'headers' => [
                'Content-Type' => 'application/json; charset=UTF-8',
            ],
            'body' => json_encode(["released" => "2023-04-21", "runtime" => "123 mins"]),
        ]);

        $contentType = $response->getHeaders()["Content-Type"][0];

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        $this->assertJson($response->getBody()->getContents());
    }

    /**
     * Test the "delete" endpoint.
     */
    public function testDelete(): void
    {
        $response = $this->http->request('DELETE', 'v1/movies/mv7120');

        $contentType = $response->getHeaders()["Content-Type"][0];

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        $this->assertJson($response->getBody()->getContents());
    }

    /**
     * Test the "getSelection" endpoint.
     */
    public function testGetSelection(): void
    {
        $response = $this->http->request('GET', 'v1/movies/' . rand(1, 5));

        $contentType = $response->getHeaders()["Content-Type"][0];

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        $this->assertJson($response->getBody()->getContents());
    }

    /**
     * Test the "getSortedSelection" endpoint.
     */
    public function testGetSortedSelection(): void
    {
        $response = $this->http->request('GET', 'v1/movies/' . rand(1, 5) . '/sort/year');

        $contentType = $response->getHeaders()["Content-Type"][0];

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        $this->assertJson($response->getBody()->getContents());
    }
}
