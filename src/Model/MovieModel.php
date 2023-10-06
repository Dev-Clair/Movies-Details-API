<?php

declare(strict_types=1);

namespace src\Model;

use src\Interface\ModelInterface;
use src\Db\DbConn;
use PDOStatement;

class MovieModel extends MainModel implements ModelInterface
{
    public function __construct(?DbConn $dbConn = null)
    {
        parent::__construct($dbConn);
    }


    public function createMovie(string $tableName, array $sanitizedData): bool|self
    {
        return $this->dbConn?->createResource(tableName: $tableName, sanitizedData: $sanitizedData);
    }


    public function retrieveAllMovies(string $tableName): array|false|self
    {
        return $this->dbConn?->retrieveAllResources(tableName: $tableName);
    }


    public function updateMovie(string $tableName, array $sanitizedData, array $fieldName, mixed $fieldValue): bool|self
    {
        return $this->dbConn?->updateResource(tableName: $tableName, sanitizedData: $sanitizedData, fieldName: $fieldName, fieldValue: $fieldValue);
    }


    public function deleteMovie(string $tableName, array $fieldName, mixed $fieldValue): bool|self
    {
        return $this->dbConn?->deleteResource(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }


    public function retrieveSingleMovie(string $tableName, array $fieldName, mixed $fieldValue): PDOStatement|self
    {
        return $this->dbConn?->retrieveSpecificResource_firstOccurrence(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }


    public function retrieveMovieAttribute(string $tableName, array $fieldName, string $compareFieldName, mixed $compareFieldValue): PDOStatement|self
    {
        return $this->dbConn?->retrieveResource_SingleFieldValue(tableName: $tableName, fieldName: $fieldName, compareFieldName: $compareFieldName, compareFieldValue: $compareFieldValue);
    }


    public function validateMovie(string $tableName, array $fieldName, mixed $fieldValue): bool|self
    {
        return $this->dbConn?->validateResource(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }


    public function searchMovie(string $tableName, array $fieldName, mixed $fieldValue): array|false|self
    {
        return $this->dbConn?->searchResource(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }


    public function sortMovie(string $tableName, string $fieldName): array|false|self
    {
        return $this->dbConn?->sortResource(tableName: $tableName, fieldName: $fieldName);
    }
}
