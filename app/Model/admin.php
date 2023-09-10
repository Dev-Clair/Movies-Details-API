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
$moviesTable = "movies";
$moviesTableFields = "`user_id` VARCHAR(20) PRIMARY KEY,
                     `user_name` VARCHAR(150) NOT NULL,
                     `user_email` VARCHAR(150) UNIQUE NOT NULL,
                     `user_password` VARCHAR(255) NOT NULL,
                     `user_address` VARCHAR(150),
                     `user_role` ENUM('ADMIN', 'CUSTOMER') DEFAULT 'CUSTOMER',
                     `user_account_status` ENUM('Active', 'Inactive') DEFAULT 'Active'";

$databaseTables = [$moviesTable => $moviesTableFields];

$conn = new AdminModel(databaseName: $databaseName);
foreach ($databaseTables as $tableName => $fieldNames) {
    $status = $conn->createTable(tableName: $tableName, fieldNames: $fieldNames);
    if ($status) {
        echo "Creating new table `$tableName` in $databaseName returned: " . "true" . PHP_EOL;
    } else {
        echo "Creating new table `$tableName` in $databaseName returned: " . "false" . PHP_EOL;
    }
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
