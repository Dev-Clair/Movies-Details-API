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

    private function invalidArgumentCheck()
    {
        $args = func_get_args();
        foreach ($args as $arg) {
            if (empty($arg)) {
                throw new InvalidArgumentException($arg  . "is invalid");
            }
        }
    }


    // Basic CRUD Methods
    public function createMovie(string $tableName, array $sanitizedData): PDOStatement
    {
        $this->invalidArgumentCheck();

        return $this->dbTableOp->createResource(tableName: $tableName, sanitizedData: $sanitizedData);
    }


    public function retrieveAllMovies(string $tableName): array
    {
        $this->invalidArgumentCheck();

        return $this->dbTableOp->retrieveAllResources(tableName: $tableName);
    }


    public function updateMovie(string $tableName, array $sanitizedData, array $fieldName, mixed $fieldValue): PDOStatement
    {
        $this->invalidArgumentCheck();

        return $this->dbTableOp->updateResource(tableName: $tableName, sanitizedData: $sanitizedData, fieldName: $fieldName, fieldValue: $fieldValue);
    }


    public function deleteMovie(string $tableName, array $fieldName, mixed $fieldValue): PDOStatement
    {
        $this->invalidArgumentCheck();

        return $this->dbTableOp->deleteResource(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }


    // Advanced CRUD Methods
    public function retrieveSingleMovie(string $tableName, array $fieldName, mixed $fieldValue): PDOStatement
    {
        $this->invalidArgumentCheck();

        return $this->dbTableOp->retrieveSpecificResource_firstOccurrence(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }

    public function retrieveMovieAttribute(string $tableName, array $fieldName, string $compareFieldName, mixed $compareFieldValue): mixed
    {
        $this->invalidArgumentCheck();

        return $this->dbTableOp->retrieveResource_SingleFieldValue(tableName: $tableName, fieldName: $fieldName, compareFieldName: $compareFieldName, compareFieldValue: $compareFieldValue);
    }


    public function validateMovie(string $tableName, array $fieldName, mixed $fieldValue): bool
    {
        $this->invalidArgumentCheck();

        return $this->dbTableOp->validateResource(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }


    public function searchMovie(string $tableName, array $fieldName, mixed $fieldValue): array
    {
        $this->invalidArgumentCheck();

        return $this->dbTableOp->searchResource(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }
}
