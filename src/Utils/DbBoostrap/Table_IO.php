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
        'title' => 'Titanic',
        'year' => '1997',
        'released' => '1997-09-25',
        'runtime' => '194 mins',
        'directors' => 'Ewan Stewart, Jonny Phillips, Jason Barry, Alex Owens-Sarno',
        'actors' => 'Leonardo D.  Caprio, Bill Paxton, Kate Winslow',
        'country' => 'United States',
        'poster' => 'https://example.com/poster_titanic.jpg',
        'imdb' => '8/10',
        'type' => 'Blockbuster'
    ],
    [
        'uid' => "mv" . $catalogue_no++,
        'title' => 'Vacation Friends',
        'year' => '2021',
        'released' => '2021-02-25',
        'runtime' => '105 mins',
        'directors' => 'John Tyler',
        'actors' => 'John Cena, Tobi Ray',
        'country' => 'United States',
        'poster' => 'https://example.com/poster_vacation_friends.jpg',
        'imdb' => '8/10',
        'type' => 'Comedy'
    ],
    [
        'uid' => "mv" . $catalogue_no++,
        'title' => 'Vacation Friends 2',
        'year' => '2023',
        'released' => '2023-08-05',
        'runtime' => '107 mins',
        'directors' => 'John Tyler',
        'actors' => 'John Cena, Tobi Ray, Jenny Jenkins',
        'country' => 'United States',
        'poster' => 'https://example.com/poster_vacation_friends_2.jpg',
        'imdb' => '10/10',
        'type' => 'Comedy'
    ],
    [
        "uid" => "mv" . $catalogue_no++,
        "title" => "The Lord of the Rings: Rings of Power",
        "year" => "2022",
        "released" => "2020-02-10",
        "runtime" => "45 mins",
        "directors" => "Ron Ames, Chris Newman",
        "actors" => "Morfydd Clark, Robert Aramayo, Sophia Nomvete",
        "country" => "United States",
        "poster" => "https://example.com/poster_rings_of_power.jpg",
        "imdb" => "10/10",
        "type" => "Drama"
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
        'poster' => 'https://example.com/poster_captain_marvel.jpg',
        'imdb' => '10/10',
        'type' => 'Action, Thriller'
    ],
    [
        'uid' => "mv" . $catalogue_no++,
        'title' => 'House of Dragon',
        'year' => '2022',
        'released' => '2022-02-25',
        'runtime' => '45 mins',
        'directors' => 'John Tyler',
        'actors' => 'Sean Longstaff, Mike Robin, Ethan Hunts',
        'country' => 'United States',
        'poster' => 'https://example.com/poster_house_of_dragon.jpg',
        'imdb' => '7/10',
        'type' => 'Action, Adventure'
    ],
    [
        "uid" => "mv" . $catalogue_no++,
        "title" => "The Lord of the Rings: The Fellowship of the RIngs",
        "year" => "2001",
        "released" => "2001-05-17",
        "runtime" => "178 mins",
        "directors" => "Harry Sinclair, Mark Ferguson",
        "actors" => "Elijah Wood, Viggo Mortensen, Cate Blanchett",
        "country" => "United States",
        "poster" => "https://example.com/poster_lord_of_the_rings.jpg",
        "imdb" => "9/10",
        "type" => "Drama"
    ],
    [
        "uid" => "mv" . $catalogue_no++,
        "title" => "The Shawshank Redemption",
        "year" => "1994",
        "released" => "1994-09-10",
        "runtime" => "142 mins",
        "directors" => "Frank Darabont",
        "actors" => "Tim Robbins, Morgan Freeman",
        "country" => "United States",
        "poster" => "https://example.com/poster_shawshank_redemption.jpg",
        "imdb" => "9/10",
        "type" => "Drama"
    ],
    [
        "uid" => "mv" . $catalogue_no++,
        "title" => "The Godfather",
        "year" => "1972",
        "released" => "1972-03-24",
        "runtime" => "175 mins",
        "directors" => "Francis Ford Coppola",
        "actors" => "Marlon Brando, Al Pacino",
        "country" => "United States",
        "poster" => "https://example.com/poster_godfather.jpg",
        "imdb" => "9/10",
        "type" => "Crime"
    ],
    [
        "uid" => "mv" . $catalogue_no++,
        "title" => "Inception",
        "year" => "2010",
        "released" => "2010-07-16",
        "runtime" => "148 mins",
        "directors" => "Christopher Nolan",
        "actors" => "Leonardo DiCaprio, Joseph Gordon-Levitt",
        "country" => "United States",
        "poster" => "https://example.com/poster_inception.jpg",
        "imdb" => "8/10",
        "type" => "Science Fiction"
    ],
    [
        "uid" => "mv" . $catalogue_no++,
        "title" => "Die Hard",
        "year" => "1998",
        "released" => "1998-09-25",
        "runtime" => "128 mins",
        "directors" => "Bill Paxton, Kate Winslow",
        "actors" => "Bruce Willis",
        "country" => "United States",
        "poster" => "https://example.com/poster_die_hard.jpg",
        "imdb" => "8/10",
        "type" => "Action, Thriller"
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
