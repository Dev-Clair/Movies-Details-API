<?php

// create database and tables
$createDatabase = 'C:\xampp\htdocs\movie_details-API\app\Model\admin.php';

exec("php $createDatabase", $dbOutput, $dbReturnVar);

if ($dbReturnVar !== 0) {
    echo "Database and table creation failed with exit code: $dbReturnVar";
    exit();
}
echo implode("\n", $dbOutput) . PHP_EOL;

// Insert sample data into table
$addSampleData = 'C:\xampp\htdocs\movie_details-API\app\Model\main.php';

exec("php $addSampleData", $tbOutput, $tbReturnVar);

if ($tbReturnVar !== 0) {
    echo "Data insertion into table failed with exit code: $tbReturnVar";
    exit();
}
echo implode("\n", $tbOutput) . PHP_EOL;
