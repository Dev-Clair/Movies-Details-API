<?php

declare(strict_types=1);

use src\Model\MovieModel;

require __DIR__ . '/../../../vendor/autoload.php';

// Database Array
$databaseNames = ['movies', 'backup'];
$databaseName = $databaseNames[0];

/** 
 * *************************************************************************************
 * 
 * Add Record to Table
 * 
 * *************************************************************************************
 */

$catalogue_no = rand(999, 9999);

$newMovies = [
    [
        'uid' => "mv" . $catalogue_no++,
        'title' => 'Vacation Friends',
        'year' => '2021',
        'released' => '2021-02-25',
        'runtime' => '105 mins',
        'directors' => 'John Tyler',
        'actors' => 'John Cena, Tobi Ray',
        'country' => 'United States',
        'poster' => '',
        'imdb' => '8/10',
        'type' => 'Comedy'
    ],
    [
        'uid' => "mv" . $catalogue_no++,
        'title' => 'Vacation Friends 2',
        'year' => '2023',
        'released' => '2023-08-25',
        'runtime' => '107 mins',
        'directors' => 'John Tyler',
        'actors' => 'John Cena, Tobi Ray, Jenny Jenkins',
        'country' => 'United States',
        'poster' => '',
        'imdb' => '10/10',
        'type' => 'Comedy'
    ],
    [
        'uid' => "mv" . $catalogue_no++,
        'title' => 'Captain Marvel',
        'year' => '2023',
        'released' => '2023-02-12',
        'runtime' => '135 mins',
        'directors' => 'Marvel',
        'actors' => 'Steve Rogers, Tony Stark',
        'country' => 'United States',
        'poster' => '',
        'imdb' => '10/10',
        'type' => 'Action/Thriller'
    ],
    [
        'uid' => "mv" . $catalogue_no++,
        'title' => 'House of Dragon',
        'year' => '2023',
        'released' => '2021-02-25',
        'runtime' => '45 mins',
        'directors' => 'John Tyler',
        'actors' => 'Sean Longstaff, Mike Robin, Ethan Hunts',
        'country' => 'United States',
        'poster' => '',
        'imdb' => '7/10',
        'type' => 'Action, Adventure'
    ]
];

$tableName = "movie_details";
$conn = new MovieModel(databaseName: $databaseName);
foreach ($newMovies as $movies) {
    $status = $conn->createMovie(tableName: $tableName, sanitizedData: $movies);
    if ($status) {
        echo "Creating new record in $tableName returned: " . "true" . PHP_EOL;
    } else {
        echo "Creating new record in $tableName returned: " . "false" . PHP_EOL;
    }
}

/**
 * *************************************************************************************
 * 
 * Validate Record
 * 
 * *************************************************************************************
 */
$fieldName = "";
$fieldValue = "";

$tableName = "";
// $conn = new MovieModel(databaseName: $databaseName);
// $status = $conn->validateMovie(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
// if ($status) {
//     echo "Validating record in $tableName returned: " . "true" . PHP_EOL;
// } else {
//     echo "Validating record in $tableName returned: " . "false" . PHP_EOL;
// }

/**
 * *************************************************************************************
 * 
 * Retrieve All Table Records
 * 
 * *************************************************************************************
 */
$tableName = "";
// $conn = new MovieModel(databaseName: $databaseName);
// $result = $conn->retrieveAllMovies(tableName: $tableName, fetchMode: "1");
// echo "Retrieving all records in $tableName: " . PHP_EOL;
// var_dump($result);

/**
 * *************************************************************************************
 * 
 * Retrieve Single Table Record
 * 
 * *************************************************************************************
 */
$fieldName = "";
$fieldValue = "";

$tableName = "";
// $conn = new MovieModel(databaseName: $databaseName);
// $result = $conn->retrieveSingleMovie(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
// echo "Retrieving single record in $tableName: " . PHP_EOL;
// var_dump($result);

/**
 * *************************************************************************************
 * 
 * Update Table Record
 * 
 * *************************************************************************************
 */
$record = []; // Record must be passed as an associative array
$fieldName = "";
$fieldValue = "";

$tableName = "";
// $conn = new MovieModel(databaseName: $databaseName);
// $status = $conn->updateMovie(tableName: $tableName, sanitizedData: $record, fieldName: $fieldName, fieldValue: $fieldValue);
// if ($status) {
//     echo "Updating record in $tableName returned: " . "true" . PHP_EOL;
// } else {
//     echo "Updating record in $tableName returned: " . "false" . PHP_EOL;
// }

/**
 * *************************************************************************************
 * 
 * Delete Table Record
 * 
 * *************************************************************************************
 */
$fieldName = "";
$fieldValue = "";

$tableName = "";
// $conn = new MovieModel(databaseName: $databaseName);
// $status = $conn->deleteMovie(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
// if ($status) {
//     echo "Deleting record in $tableName returned: " . "true" . PHP_EOL;
// } else {
//     echo "Deleting record in $tableName returned: " . "false" . PHP_EOL;
// }
