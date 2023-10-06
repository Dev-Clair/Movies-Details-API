<?php

declare(strict_types=1);

namespace src\Model;

use Dotenv\Dotenv;
use src\Db\DbConn;

abstract class MainModel
{
    protected DbConn $dbConn;

    public function __construct(?DbConn $dbConn = null)
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $this->dbConn = $dbConn ?: new DbConn(
            driver: $_ENV["DSN_DRIVER"],
            serverName: $_ENV["DATABASE_HOSTNAME"],
            userName: $_ENV["DATABASE_USERNAME"],
            password: $_ENV["DATABASE_PASSWORD"],
            database: $_ENV["DATABASE"] ?? ""
        );
    }
}
