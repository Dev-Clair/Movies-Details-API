<?php

declare(strict_types=1);

namespace tests;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use src\Model\MovieModel;
use src\Controller\MovieController;

class MovieControllerTest extends TestCase
{
    // Mocked MovieModel instance
    public $movieModel;

    // Mocked MovieController instance
    public $movieController;

    protected function setUp(): void
    {
        parent::setUp();
        $this->movieModel = $this->createMock(MovieModel::class);
        $this->movieController = new MovieController($this->movieModel);
    }

    // Test getAPIInfo endpoint
    public function testGetAPIInfo()
    {
        $request = $this->createMock(Request::class);
        $response = $this->createMock(Response::class);

        $result = $this->movieController->getAPIInfo($request, $response, []);
        $this->assertEquals(200, $result->getStatusCode());
        $this->assertJson($result->getBody()->getContents());
    }

    // Test get endpoint
    public function testGet()
    {
        $request = $this->createMock(Request::class);
        $response = $this->createMock(Response::class);

        $result = $this->movieController->get($request, $response, []);
        $this->assertEquals(200, $result->getStatusCode());
        $this->assertJson($result->getBody()->getContents());
    }

    // // Test post endpoint
    // public function testPost()
    // {
    // }

    // // Test put endpoint
    // public function testPut()
    // {
    // }

    // // Test patch endpoint
    // public function testPatch()
    // {
    // }

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
