<?php

// create database
$createDatabase = 'C:\xampp\htdocs\v1\app\Utils\DbBoostrap\Database.php';

exec("php $createDatabase", $dbOutput, $dbReturnVar);

if ($dbReturnVar !== 0) {
    echo "Database creation failed. Exit code: $dbReturnVar";
    exit();
}
echo implode("\n", $dbOutput) . PHP_EOL;


// create table
$createTable = 'C:\xampp\htdocs\v1\app\Utils\DbBoostrap\Database_IO.php';

exec("php $createTable", $tbOutput, $tbReturnVar);

if ($tbReturnVar !== 0) {
    echo "Table creation failed. Exit code: $tbReturnVar";
    exit();
}
echo implode("\n", $tbOutput) . PHP_EOL;


// insert sample data into table
$addSampleData = 'C:\xampp\htdocs\v1\app\Utils\DbBoostrap\Table_IO.php';

exec("php $addSampleData", $addOutput, $addReturnVar);

if ($addReturnVar !== 0) {
    echo "Data insertion into table failed. Exit code: $addReturnVar";
    exit();
}
echo implode("\n", $addOutput) . PHP_EOL;
