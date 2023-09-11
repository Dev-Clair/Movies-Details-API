<?php

declare(strict_types=1);

use app\Model\AdminModel;

require_once __DIR__ . '/../../../vendor/autoload.php';

// Database Array
$databaseNames = ['movies', 'backup'];
$databaseName = $databaseNames[0];

/**
 * *************************************************************************************
 * 
 * Create Tables
 * 
 * *************************************************************************************
 */
$movie_details_table = "movie_details";
$movie_details_table_fields = "`uid` VARCHAR(20) PRIMARY KEY,
                                `title` VARCHAR(150) NOT NULL,
                                `year` VARCHAR(4) NOT NULL,
                                `released` VARCHAR(20) NOT NULL,
                                `runtime` VARCHAR(10) NOT NULL,
                                `directors' VARCHAR(150) NOT NULL,
                                `actors` VARCHAR(255) NOT NULL,
                                `country` VARCHAR(150) NOT NULL,
                                `poster` VARCHAR(150),
                                `imdb` VARCHAR(5) NOT NULL,
                                `type` VARCHAR(50) NOT NULL,
                                `status` ENUM('AVAILABLE', 'UNAVAILABLE') DEFAULT 'AVAILABLE'";

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
