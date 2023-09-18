<?php

declare(strict_types=1);

use src\Utils\DbGateway;

require_once __DIR__ . '/../../../vendor/autoload.php';

// Database Array
$databaseNames = ['movies', 'backup'];
$databaseName = $databaseNames[0];

/**
 * *************************************************************************************
 * 
 * Create / Drop Databases
 * 
 * *************************************************************************************
 */
$dbConn = DbGateway::dbConn($databaseName);

if (!$dbConn instanceof \PDO) {
    throw new \RuntimeException('Connection failed.');
}

$sql_query = "CREATE DATABASE IF NOT EXISTS $databaseName";
// $sql_query = "DROP DATABASE $databaseName";

if ($dbConn->query($sql_query)) {
    echo "Database creation was successful" . PHP_EOL;
} else {
    throw new \RuntimeException('Database creation failed' . PHP_EOL);
}
