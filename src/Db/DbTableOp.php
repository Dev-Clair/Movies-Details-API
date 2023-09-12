<?php

declare(strict_types=1);

namespace src\Db;

use PDO;
use PDOStatement;

class DbTableOp extends DbTable
{
    public function __construct(private ?PDO $connection)
    {
        parent::__construct($connection);
    }

    public function createRecords(string $tableName, array $sanitizedData): PDOStatement
    {
        $columns = implode(",", array_map(function ($column) {
            return "`$column`";
        }, array_keys($sanitizedData)));

        $placeholders = implode(",", array_fill(0, count($sanitizedData), "?"));

        $sql = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";
        $params = array_values($sanitizedData);
        $query_result =  $this->executeQuery(sql: $sql, params: $params);

        return $query_result;
    }

    public function validateRecord(string $tableName, $fieldName, $fieldValue): bool
    {
        $sql_query = "SELECT * FROM $tableName WHERE $fieldName = ?";

        $stmt = $this->executeQuery(sql: $sql_query, params: [$fieldValue]);
        $query_result = $stmt->rowCount() > 0;

        return $query_result;
    }

    public function searchRecord(string $tableName, string $fieldName, string $fieldValue): array|false
    {
        $sql_query = "SELECT * FROM $tableName WHERE $fieldName LIKE ?";
        $searchValue = "%$fieldValue%";

        $stmt = $this->executeQuery(sql: $sql_query, params: [$searchValue]);
        $query_result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $query_result;
    }

    public function retrieveAllRecords(string $tableName): array|false
    {
        $sql_query = "SELECT * FROM $tableName";

        $stmt = $this->executeQuery(sql: $sql_query);
        $query_result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $query_result;
    }

    public function retrieveSingleValue(string $tableName, string $fieldName, string $compareFieldName, mixed $compareFieldValue): PDOStatement
    {
        $sql_query = "SELECT $fieldName FROM $tableName WHERE $compareFieldName = ?";

        $stmt = $this->executeQuery(sql: $sql_query, params: [$compareFieldValue]);
        $query_result = $stmt->fetchColumn();

        return $query_result !== false ? $query_result : null;
    }

    public function retrieveFieldSum(string $tableName, string $fieldName, string $compareFieldName, mixed $compareFieldValue): mixed
    {
        $sql_query = "SELECT sum($fieldName) FROM $tableName WHERE $compareFieldName = ?";

        $stmt = $this->executeQuery(sql: $sql_query, params: [$compareFieldValue]);
        $query_result = $stmt->fetchColumn();

        return $query_result !== false ? $query_result : null;
    }

    public function retrieveMultipleValues(string $tableName, string $fieldName, string $compareFieldName, mixed $compareFieldValue): array|false
    {
        $sql_query = "SELECT $fieldName FROM $tableName WHERE $compareFieldName = ?";

        $stmt = $this->executeQuery(sql: $sql_query, params: [$compareFieldValue]);
        $query_result = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return $query_result;
    }

    public function retrieveSpecificRecord_firstOccurrence(string $tableName, string $fieldName, $fieldValue): PDOStatement
    {
        $sql_query = "SELECT * FROM $tableName WHERE $fieldName = ?";

        $stmt = $this->executeQuery(sql: $sql_query, params: [$fieldValue]);
        $query_result = $stmt->fetch(PDO::FETCH_ASSOC); // Fetches First Occurence for specified field value

        return $query_result ?: [];
    }

    public function retrieveSpecificRecord_allOccurrence(string $tableName, string $fieldName, $fieldValue): array
    {
        $sql_query = "SELECT * FROM $tableName WHERE $fieldName = ?";

        $stmt = $this->executeQuery(sql: $sql_query, params: [$fieldValue]);
        $query_result = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetches All Occurence for specified field value

        return $query_result;
    }

    public function updateRecord(string $tableName, array $sanitizedData, string $fieldName, mixed $fieldValue): PDOStatement
    {
        $updateFields = implode(",", array_map(function ($column) {
            return "`$column`=?";
        }, array_keys($sanitizedData)));

        $sql_query = "UPDATE $tableName SET $updateFields WHERE $fieldName = ?";

        $params = array_values($sanitizedData);
        $params[] = $fieldValue;

        $query_result = $this->executeQuery(sql: $sql_query, params: $params);

        return $query_result;
    }

    public function deleteRecord(string $tableName, string $fieldName, mixed $fieldValue): PDOStatement
    {
        $sql_query = "DELETE FROM $tableName WHERE $fieldName = ?";

        $query_result = $this->executeQuery(sql: $sql_query, params: [$fieldValue]);

        return $query_result;
    }
}
