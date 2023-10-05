<?php

declare(strict_types=1);

namespace src\Model;

use src\Db\DbConn;
use PDOStatement;

class MovieModel extends MainModel
{
    public function __construct(private ?DbConn $dbConn = null)
    {
    }


    public function createMovie(string $tableName, array $sanitizedData): bool
    {
        return $this->dbConn?->createResource(tableName: $tableName, sanitizedData: $sanitizedData);
    }


    public function retrieveAllMovies(string $tableName): array|false
    {
        return $this->dbConn?->retrieveAllResources(tableName: $tableName);
    }


    public function updateMovie(string $tableName, array $sanitizedData, array $fieldName, mixed $fieldValue): bool
    {
        return $this->dbConn?->updateResource(tableName: $tableName, sanitizedData: $sanitizedData, fieldName: $fieldName, fieldValue: $fieldValue);
    }


    public function deleteMovie(string $tableName, array $fieldName, mixed $fieldValue): bool
    {
        return $this->dbConn?->deleteResource(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }


    public function retrieveSingleMovie(string $tableName, array $fieldName, mixed $fieldValue): PDOStatement
    {
        return $this->dbConn?->retrieveSpecificResource_firstOccurrence(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }


    public function retrieveMovieAttribute(string $tableName, array $fieldName, string $compareFieldName, mixed $compareFieldValue): mixed
    {
        return $this->dbConn?->retrieveResource_SingleFieldValue(tableName: $tableName, fieldName: $fieldName, compareFieldName: $compareFieldName, compareFieldValue: $compareFieldValue);
    }


    public function validateMovie(string $tableName, array $fieldName, mixed $fieldValue): bool
    {
        return $this->dbConn?->validateResource(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }


    public function searchMovie(string $tableName, array $fieldName, mixed $fieldValue): array|false
    {
        return $this->dbConn?->searchResource(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }


    public function sortMovie(string $tableName, string $fieldName): array|false
    {
        return $this->dbConn?->sortResource(tableName: $tableName, fieldName: $fieldName);
    }
}
