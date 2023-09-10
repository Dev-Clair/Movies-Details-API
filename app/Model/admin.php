<?php

declare(strict_types=1);

use app\Utils\DbResource;
use app\Model\AdminModel;

require_once __DIR__ . '/../../vendor/autoload.php';

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

$dbConn = DbResource::dbConn($databaseName);

if (!$dbConn instanceof \PDO) {
    throw new \RuntimeException('Connection failed.');
}

$sql_query = "CREATE DATABASE IF NOT EXISTS $databaseName";
// $sql_query = "DROP DATABASE $databaseName";

if ($dbConn->query($sql_query)) {
    echo "Database operation was successful" . PHP_EOL;
} else {
    throw new \RuntimeException('Database operation failed' . PHP_EOL);
}

/**
 * *************************************************************************************
 * 
 * Create Tables
 * 
 * *************************************************************************************
 */
$movie_details_table = "movie_details";
$movie_details_table_fields = "`movie_id` VARCHAR(20) PRIMARY KEY,
                                `movie_title` VARCHAR(150) NOT NULL,
                                `movie_rating` VARCHAR(150) NOT NULL,
                                `movie_release_date` VARCHAR(255) NOT NULL,
                                `movie_genre` VARCHAR(150),
                                `movie_status` ENUM('AVAILABLE', 'UNAVAILABLE') DEFAULT 'AVAILABLE'";

$databaseTables = [$movie_details_table => $movie_details_table_fields];

$conn = new AdminModel(databaseName: $databaseName);
$status = $conn->createTable(tableName: $movie_details_table, fieldNames: $movie_details_table_fields);
if ($status) {
    echo "Creating new table `$movie_details_table` in $databaseName returned: " . "true" . PHP_EOL;
} else {
    echo "Creating new table `$movie_details_table` in $databaseName returned: " . "false" . PHP_EOL;
}

/** *************************************************************************************
 * 
 * Alter Tables
 * 
 * *************************************************************************************
 */
$tableName = "";
$alterStatement = "ADD COLUMN ``  NOT NULL FIRST";
// $conn = new AdminModel(databaseName: $databaseName);
// $status = $conn->alterTable(tableName: $tableName, alterStatement: $alterStatement);
// if ($status) {
//     echo "Modifying $tableName table in $databaseName returned: " . "true" . PHP_EOL;
// } else {
//     echo "Modifying $tableName table in $databaseName returned: " . "false" . PHP_EOL;
// }

/** 
 * *************************************************************************************
 * 
 * Truncate Tables
 * 
 * *************************************************************************************
 */
$tableName = "";
// $conn = new AdminModel(databaseName: $databaseName);
// $status = $conn->truncateTable(tableName: $tableName);
// if ($status) {
//     echo "Clearing all $tableName records in $databaseName returned: " . "true" . PHP_EOL;
// } else {
//     echo "Clearing all $tableName records in $databaseName returned: " . "false" . PHP_EOL;
// }

/** 
 * *************************************************************************************
 * 
 * Drop Tables
 * 
 * *************************************************************************************
 */
$tableName = "";
// $conn = new AdminModel(databaseName: $databaseName);
// $status = $conn->dropTable(tableName: $tableName);
// if ($status) {
//     echo "Deleting table `$tableName` in $databaseName returned: " . "true" . PHP_EOL;
// } else {
//     echo "Deleting table `$tableName` in $databaseName returned: " . "false" . PHP_EOL;
// }
