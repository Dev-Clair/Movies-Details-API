<?php

use Slim\Factory\AppFactory;
use Dotenv\Dotenv;
use src\Db\DbConn;
use src\Model\MovieModel;

require __DIR__ . '/../vendor/autoload.php';


$app = AppFactory::create();


// Create Database Instance
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$dbConn = new DbConn(
    driver: $_ENV["DSN_DRIVER"],
    serverName: $_ENV["DATABASE_HOSTNAME"],
    userName: $_ENV["DATABASE_USERNAME"],
    password: $_ENV["DATABASE_PASSWORD"],
    database: $_ENV["DATABASE"] ?? ""
);

$dbConn = $dbConn->getConnection();

// $movieModel = new MovieModel(DbConn $dbConn);

// Add Routing Middleware
$app->addRoutingMiddleware();

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Route to API documentation
$app->get('/openapi', function () {
    require __DIR__ . '/openapi/index.php';
});

// Routes to Application Endpoints and Middlewares for CRUD Related Operations
require __DIR__ . '/../movies.php';

$app->run();
