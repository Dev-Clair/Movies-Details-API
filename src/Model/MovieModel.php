<?php

declare(strict_types=1);

namespace src\Model;

use src\Db\DbConn;
use PDOStatement;
use InvalidArgumentException;

class MovieModel extends MainModel
{
    public function __construct(protected DbConn $dbConn)
    {
        parent::__construct($dbConn);
    }

    private function invalid_arg_check(array $args)
    {
        foreach ($args as $argName => $argValue) {
            if (empty($argValue)) {
                throw new InvalidArgumentException("$argName is either null, false or not set.");
            }
        }
    }


    private function arg_num_check(int $expectedArgs, int $suppliedArgs)
    {
        if ($expectedArgs !== $suppliedArgs) {
            throw new InvalidArgumentException("Invalid number of arguments supplied. Expected: $expectedArgs, Supplied: $suppliedArgs");
        }
    }


    // Basic CRUD Methods
    public function createMovie(string $tableName, array $sanitizedData): bool
    {
        $this->arg_num_check(2, func_num_args());
        $this->invalid_arg_check(['tableName' => $tableName, 'sanitizedData' => $sanitizedData]);

        return $this->dbConn->createResource(tableName: $tableName, sanitizedData: $sanitizedData);
    }


    public function retrieveAllMovies(string $tableName): array|false
    {
        $this->arg_num_check(1, func_num_args());
        $this->invalid_arg_check(['tableName' => $tableName]);

        return $this->dbConn->retrieveAllResources(tableName: $tableName);
    }


    public function updateMovie(string $tableName, array $sanitizedData, array $fieldName, mixed $fieldValue): bool
    {
        $this->arg_num_check(4, func_num_args());
        $this->invalid_arg_check(['tableName' => $tableName, 'sanitizedData' => $sanitizedData, 'fieldName' => $fieldName, 'fieldValue' => $fieldValue]);

        return $this->dbConn->updateResource(tableName: $tableName, sanitizedData: $sanitizedData, fieldName: $fieldName, fieldValue: $fieldValue);
    }


    public function deleteMovie(string $tableName, array $fieldName, mixed $fieldValue): bool
    {
        $this->arg_num_check(3, func_num_args());
        $this->invalid_arg_check(['tableName' => $tableName, 'fieldName' => $fieldName, 'fieldValue' => $fieldValue]);

        return $this->dbConn->deleteResource(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }


    // Advanced CRUD Methods
    public function retrieveSingleMovie(string $tableName, array $fieldName, mixed $fieldValue): PDOStatement
    {
        $this->arg_num_check(1, func_num_args());
        $this->invalid_arg_check(['tableName' => $tableName, 'fieldName' => $fieldName, 'fieldValue' => $fieldValue]);

        return $this->dbConn->retrieveSpecificResource_firstOccurrence(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }

    public function retrieveMovieAttribute(string $tableName, array $fieldName, string $compareFieldName, mixed $compareFieldValue): mixed
    {
        $this->arg_num_check(4, func_num_args());
        $this->invalid_arg_check(['tableName' => $tableName, 'fieldName' => $fieldName, 'compareFieldName' => $compareFieldName, 'compareFieldValue' => $compareFieldValue]);

        return $this->dbConn->retrieveResource_SingleFieldValue(tableName: $tableName, fieldName: $fieldName, compareFieldName: $compareFieldName, compareFieldValue: $compareFieldValue);
    }


    public function validateMovie(string $tableName, array $fieldName, mixed $fieldValue): bool
    {
        $this->arg_num_check(3, func_num_args());
        $this->invalid_arg_check(['tableName' => $tableName, 'fieldName' => $fieldName, 'fieldValue' => $fieldValue]);

        return $this->dbConn->validateResource(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }


    public function searchMovie(string $tableName, array $fieldName, mixed $fieldValue): array|false
    {
        $this->arg_num_check(3, func_num_args());
        $this->invalid_arg_check(['tableName' => $tableName, 'fieldName' => $fieldName, 'fieldValue' => $fieldValue]);

        return $this->dbConn->searchResource(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }


    public function sortMovie(string $tableName, string $fieldName): array|false
    {
        $this->arg_num_check(2, func_num_args());
        $this->invalid_arg_check(['tableName' => $tableName, 'fieldName' => $fieldName]);

        return $this->dbConn->sortResource(tableName: $tableName, fieldName: $fieldName);
    }
}
