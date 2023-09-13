<?php

declare(strict_types=1);

namespace src\Model;

use PDOStatement;
use InvalidArgumentException;

class MovieModel extends MainModel
{
    public function __construct(protected ?string $databaseName = null)
    {

        parent::__construct($databaseName);
    }

    private function invalidArgumentCheck(array $args)
    {
        foreach ($args as $argName => $argValue) {
            if (empty($argValue)) {
                throw new InvalidArgumentException("$argName is either null, false or not set.");
            }
        }
    }


    private function argumentNumberCheck(int $expectedArgs, int $suppliedArgs)
    {
        if ($expectedArgs !== $suppliedArgs) {
            throw new InvalidArgumentException("Invalid number of arguments supplied. Expected: $expectedArgs, Supplied: $suppliedArgs");
        }
    }


    // Basic CRUD Methods
    public function createMovie(string $tableName, array $sanitizedData): PDOStatement
    {
        $this->argumentNumberCheck(2, func_num_args());
        $this->invalidArgumentCheck(['tableName' => $tableName, 'sanitizedData' => $sanitizedData]);

        return $this->dbTableOp->createResource(tableName: $tableName, sanitizedData: $sanitizedData);
    }


    public function retrieveAllMovies(string $tableName): array
    {
        $this->argumentNumberCheck(1, func_num_args());
        $this->invalidArgumentCheck(['tableName' => $tableName]);

        return $this->dbTableOp->retrieveAllResources(tableName: $tableName);
    }


    public function updateMovie(string $tableName, array $sanitizedData, array $fieldName, mixed $fieldValue): PDOStatement
    {
        $this->argumentNumberCheck(4, func_num_args());
        $this->invalidArgumentCheck([
            'tableName' => $tableName,
            'sanitizedData' => $sanitizedData,
            'fieldName' => $fieldName,
            'fieldValue' => $fieldValue
        ]);

        return $this->dbTableOp->updateResource(tableName: $tableName, sanitizedData: $sanitizedData, fieldName: $fieldName, fieldValue: $fieldValue);
    }


    public function deleteMovie(string $tableName, array $fieldName, mixed $fieldValue): PDOStatement
    {
        $this->argumentNumberCheck(3, func_num_args());
        $this->invalidArgumentCheck([
            'tableName' => $tableName,
            'fieldName' => $fieldName,
            'fieldValue' => $fieldValue
        ]);

        return $this->dbTableOp->deleteResource(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }


    // Advanced CRUD Methods
    public function retrieveSingleMovie(string $tableName, array $fieldName, mixed $fieldValue): PDOStatement
    {
        $this->argumentNumberCheck(1, func_num_args());
        $this->invalidArgumentCheck([
            'tableName' => $tableName,
            'fieldName' => $fieldName,
            'fieldValue' => $fieldValue
        ]);

        return $this->dbTableOp->retrieveSpecificResource_firstOccurrence(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }

    public function retrieveMovieAttribute(string $tableName, array $fieldName, string $compareFieldName, mixed $compareFieldValue): mixed
    {
        $this->argumentNumberCheck(4, func_num_args());
        $this->invalidArgumentCheck([
            'tableName' => $tableName,
            'fieldName' => $fieldName,
            'compareFieldName' => $compareFieldName,
            'compareFieldValue' => $compareFieldValue
        ]);

        return $this->dbTableOp->retrieveResource_SingleFieldValue(tableName: $tableName, fieldName: $fieldName, compareFieldName: $compareFieldName, compareFieldValue: $compareFieldValue);
    }


    public function validateMovie(string $tableName, array $fieldName, mixed $fieldValue): bool
    {
        $this->argumentNumberCheck(3, func_num_args());
        $this->invalidArgumentCheck([
            'tableName' => $tableName,
            'fieldName' => $fieldName,
            'fieldValue' => $fieldValue
        ]);

        return $this->dbTableOp->validateResource(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }


    public function searchMovie(string $tableName, array $fieldName, mixed $fieldValue): array
    {
        $this->argumentNumberCheck(3, func_num_args());
        $this->invalidArgumentCheck([
            'tableName' => $tableName,
            'fieldName' => $fieldName,
            'fieldValue' => $fieldValue
        ]);

        return $this->dbTableOp->searchResource(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }
}
