<?php

declare(strict_types=1);

use app\Model\MovieModel;

require __DIR__ . '/../../vendor/autoload.php';

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
        'movie_id' => "mv" . $catalogue_no++,
        'movie_title' => 'Vacation Friends',
        'movie_rating' => '8/10',
        'movie_release_date' => '2021-02-25',
        'movie_genre' => 'Comedy'
    ],
    [
        'movie_id' => "mv" . $catalogue_no++,
        'movie_title' => 'Vacation Friends 2',
        'movie_rating' => '10/10',
        'movie_release_date' => '2023-08-25',
        'movie_genre' => 'Comedy'
    ],
    [
        'movie_id' => "mv" . $catalogue_no++,
        'movie_title' => 'Captain Marvel 2',
        'movie_rating' => '10/10',
        'movie_release_date' => '2023-02-25',
        'movie_genre' => 'Action/Thriller'
    ],
    [
        'movie_id' => "mv" . $catalogue_no++,
        'movie_title' => 'House of Dragon',
        'movie_rating' => '10/10',
        'movie_release_date' => '2023-09-20',
        'movie_genre' => 'Action'
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
