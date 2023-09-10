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
        'Movie_id' => "bk" . $catalogue_no++,
        'Movie_title' => 'The Great Gatsby',
        'Movie_author' => 'F. Scott Fitzgerald',
        'Movie_edition' => '1st',
        'Movie_price' => 25.99,
        'Movie_qty' => 50,
        'Movie_cover_image' => null,
        'Movie_publication_date' => '2022-01-15'
    ],
    [
        'Movie_id' => "bk" . $catalogue_no++,
        'Movie_title' => 'To Kill a Mockingbird',
        'Movie_author' => 'Harper Lee',
        'Movie_edition' => '2nd',
        'Movie_price' => 19.95,
        'Movie_qty' => 30,
        'Movie_cover_image' => null,
        'Movie_publication_date' => '2021-08-10'
    ],
    [
        'Movie_id' => "bk" . $catalogue_no++,
        'Movie_title' => 'The Catcher in the Rye',
        'Movie_author' => 'J.D. Salinger',
        'Movie_edition' => '5th',
        'Movie_price' => 10.05,
        'Movie_qty' => 20,
        'Movie_cover_image' => null,
        'Movie_publication_date' => '2018-07-11'
    ],
    [
        'Movie_id' => "bk" . $catalogue_no++,
        'Movie_title' => 'Harry Potter and the Sorcerer\'s Stone',
        'Movie_author' => 'J.K. Rowling',
        'Movie_edition' => '4th',
        'Movie_price' => 39.95,
        'Movie_qty' => 15,
        'Movie_cover_image' => null,
        'Movie_publication_date' => '2015-12-03'
    ],
    [
        'Movie_id' => "bk" . $catalogue_no++,
        'Movie_title' => 'The Alchemist',
        'Movie_author' => 'Paulo Coelho',
        'Movie_edition' => '1st',
        'Movie_price' => 11.95,
        'Movie_qty' => 55,
        'Movie_cover_image' => null,
        'Movie_publication_date' => '2016-06-03'
    ],
    [
        'Movie_id' => "bk" . $catalogue_no++,
        'Movie_title' => 'The Great Gatsby',
        'Movie_author' => 'F. Scott Fitzgerald',
        'Movie_edition' => '2nd',
        'Movie_price' => 35,
        'Movie_qty' => 20,
        'Movie_cover_image' => null,
        'Movie_publication_date' => '2023-01-15'
    ],
    [
        'Movie_id' => "bk" . $catalogue_no++,
        'Movie_title' => 'Engineering Mathematics',
        'Movie_author' => 'K. A. Stroud',
        'Movie_edition' => '5th',
        'Movie_price' => 9.99,
        'Movie_qty' => 25,
        'Movie_cover_image' => null,
        'Movie_publication_date' => '2004-08-03'
    ],
    [
        'Movie_id' => "bk" . $catalogue_no++,
        'Movie_title' => 'Building Construction',
        'Movie_author' => 'Derek Osbourn and Roger Greeno',
        'Movie_edition' => '4th',
        'Movie_price' => 24.99,
        'Movie_qty' => 45,
        'Movie_cover_image' => null,
        'Movie_publication_date' => '1997-01-15'
    ]
];

$tableName = "Movies";
$conn = new MovieModel(databaseName: $databaseName);

foreach ($newMovies as $Movie) {
    $status = $conn->createMovie(tableName: $tableName, sanitizedData: $Movie);
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
