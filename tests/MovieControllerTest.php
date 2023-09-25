<?php

declare(strict_types=1);

namespace tests;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;


class MovieControllerTest extends TestCase
{
    private Client $http;

    protected function setUp(): void
    {
        $this->http = new Client(['base_uri' => 'http://localhost:8888/']);
    }

    // protected function tearDown(): void
    // {
    //     $this->http = null;
    // }

    // Test getAPIInfo endpoint
    public function testGetAPIInfo()
    {
        $response = $this->http->request('GET', 'v1');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        $this->assertJson($response->getBody()->getContents());

        // Test for not allowed request methods to endpoints
        // $response = $this->http->request('PUT', 'v1/movies');

        // $this->assertEquals(405, $response->getStatusCode());
    }

    // Test get endpoint
    public function testGet()
    {
        $response = $this->http->request('GET', 'v1/movies');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        $this->assertJson($response->getBody()->getContents());

        // Test for not allowed request methods to endpoints
        // $response = $this->http->request('PATCH', 'v1/movies');

        // $this->assertEquals(405, $response->getStatusCode());
    }

    // Test post endpoint
    public function testPost()
    {
        $response = $this->http->request('POST', 'v1/movies', [
            'headers' => [
                'Content-Type' => 'application/json',
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
                "imdb" => "8/10",
                "type" => "Action, Thriller"
            ]),
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        $this->assertJson($response->getBody()->getContents());

        // Test for not allowed request methods to endpoints
        // $response = $this->http->request('DELETE', 'v1/movies');

        // $this->assertEquals(405, $response->getStatusCode());
    }

    // // Test put endpoint
    // public function testPut()
    // {
    // }

    // Test patch endpoint
    public function testPatch()
    {
        $response = $this->http->request('POST', 'v1/movies/7120', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode(["released" => "2023-04-21", "runtime" => "123 mins"]),
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        $this->assertJson($response->getBody()->getContents());

        // Test for not allowed request methods to endpoints
        // $response = $this->http->request('GET', 'v1/movies/7120');

        // $this->assertEquals(405, $response->getStatusCode());
    }

    // // Test delete endpoint
    // public function testDelete()
    // {
    // }

    // // Test getSelection endpoint
    // public function testGetSelection()
    // {
    // }

    // // Test getSortedSelection endpoint
    // public function testGetSortedSelection()
    // {
    // }

    // // Test getSearch endpoint
    // public function testGetSearch()
    // {
    // }
}
