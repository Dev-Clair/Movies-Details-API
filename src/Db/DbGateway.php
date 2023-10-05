<?php

declare(strict_types=1);

namespace src\Db;

use Dotenv\Dotenv;
use src\Db\DbConn;
use src\Db\DbTable;

class DbGateway
{
    /**
     * *************************************************************************************
     * 
     * Establishes and Provides Resource: PDO Connection Object
     * 
     * *************************************************************************************
     */
    private function getConnection(?string $databaseName = null)
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $conn = new DbConn(
            driver: $_ENV["DSN_DRIVER"],
            serverName: $_ENV["DATABASE_HOSTNAME"],
            userName: $_ENV["DATABASE_USERNAME"],
            password: $_ENV["DATABASE_PASSWORD"],
            database: $databaseName
        );

        return $conn->getConnection();
    }

    /**
     * *************************************************************************************
     * 
     * Provides Resource: PDO Connection Object to Create / Drop Database
     * 
     * *************************************************************************************
     */
    public function dbConn(): ?\PDO
    {
        $conn = $this->getConnection();
        return $conn;
    }

    /**
     * *************************************************************************************
     * 
     * Provides Resource: PDO Connection Object to Create/Drop/Truncate/Alter Table
     * 
     * *************************************************************************************
     */
    public function getTableConnection(?string $databaseName = null): DbTable
    {
        $conn = $this->getConnection($databaseName);
        return new DbTable($conn);
    }
}
