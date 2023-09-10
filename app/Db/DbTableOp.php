<?php

declare(strict_types=1);

namespace app\Db;

use PDO;
use PDOException;

class DbTableOp extends DbTable
{
    public function __construct(private ?PDO $connection)
    {
        parent::__construct($connection);
    }

    public function createRecords(string $tableName, array $sanitizedData): bool
    {
        $columns = implode(",", array_map(function ($column) {
            return "`$column`";
        }, array_keys($sanitizedData)));

        $placeholders = implode(",", array_fill(0, count($sanitizedData), "?"));

        $sql = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";

        try {
            $params = array_values($sanitizedData);
            $this->executeQuery(sql: $sql, params: $params);
            return true;
        } catch (PDOException $e) {
            throw new \RuntimeException("Error executing statement: " . $e->getMessage());
        }
    }

    public function validateRecord(string $tableName, $fieldName, $fieldValue): bool
    {
        $sql_query = "SELECT * FROM $tableName WHERE $fieldName = ?";

        try {
            $stmt = $this->executeQuery(sql: $sql_query, params: [$fieldValue]);
            $validFieldValue = $stmt->rowCount() > 0;
            return $validFieldValue;
        } catch (PDOException $e) {
            throw new \RuntimeException("Error executing statement: " . $e->getMessage());
        }
    }

    public function searchRecord(string $tableName, string $fieldName, string $fieldValue): array
    {
        $sql_query = "SELECT * FROM $tableName WHERE $fieldName LIKE ?";
        $searchValue = "%$fieldValue%";

        try {
            $stmt = $this->executeQuery(sql: $sql_query, params: [$searchValue]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            throw new \RuntimeException("Error executing statement: " . $e->getMessage());
        }
    }

    public function retrieveAllRecords(string $tableName): array
    {
        $sql_query = "SELECT * FROM $tableName";
        try {
            $stmt = $this->executeQuery(sql: $sql_query);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            throw new \RuntimeException("Error executing statement: " . $e->getMessage());
        }
    }

    public function retrieveSingleValue(string $tableName, string $fieldName, string $compareFieldName, mixed $compareFieldValue): int|string|null
    {
        $sql_query = "SELECT $fieldName FROM $tableName WHERE $compareFieldName = ?";

        try {
            $stmt = $this->executeQuery(sql: $sql_query, params: [$compareFieldValue]);
            $value = $stmt->fetchColumn();

            return $value !== false ? $value : null;
        } catch (PDOException $e) {
            throw new \RuntimeException("Error executing statement: " . $e->getMessage());
        }
    }

    public function retrieveFieldSum(string $tableName, string $fieldName, string $compareFieldName, mixed $compareFieldValue): mixed
    {
        $sql_query = "SELECT sum($fieldName) FROM $tableName WHERE $compareFieldName = ?";

        try {
            $stmt = $this->executeQuery(sql: $sql_query, params: [$compareFieldValue]);
            $value = $stmt->fetchColumn();

            return $value !== false ? $value : null;
        } catch (PDOException $e) {
            throw new \RuntimeException("Error executing statement: " . $e->getMessage());
        }
    }

    public function retrieveMultipleValues(string $tableName, string $fieldName, string $compareFieldName, mixed $compareFieldValue): array
    {
        $sql_query = "SELECT $fieldName FROM $tableName WHERE $compareFieldName = ?";
        try {
            $stmt = $this->executeQuery(sql: $sql_query, params: [$compareFieldValue]);
            $columnValues = $stmt->fetchAll(PDO::FETCH_COLUMN);
            return $columnValues;
        } catch (PDOException $e) {
            throw new \RuntimeException("Error executing statement: " . $e->getMessage());
        }
    }

    public function retrieveSpecificRecord_firstOccurrence(string $tableName, string $fieldName, $fieldValue): array
    {
        $sql_query = "SELECT * FROM $tableName WHERE $fieldName = ?";

        try {
            $stmt = $this->executeQuery(sql: $sql_query, params: [$fieldValue]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC); // Fetches First Occurence for specified field value
            return $result ?: [];
        } catch (PDOException $e) {
            throw new \RuntimeException("Error executing statement: " . $e->getMessage());
        }
    }

    public function retrieveSpecificRecord_allOccurrence(string $tableName, string $fieldName, $fieldValue): array
    {
        $sql_query = "SELECT * FROM $tableName WHERE $fieldName = ?";

        try {
            $stmt = $this->executeQuery(sql: $sql_query, params: [$fieldValue]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetches All Occurence for specified field value
            return $results;
        } catch (PDOException $e) {
            throw new \RuntimeException("Error executing statement: " . $e->getMessage());
        }
    }

    public function updateRecord(string $tableName, array $sanitizedData, string $fieldName, mixed $fieldValue): bool
    {
        $updateFields = implode(",", array_map(function ($column) {
            return "`$column`=?";
        }, array_keys($sanitizedData)));

        $sql_query = "UPDATE $tableName SET $updateFields WHERE $fieldName = ?";

        $params = array_values($sanitizedData);
        $params[] = $fieldValue;

        try {
            $this->executeQuery(sql: $sql_query, params: $params);
            return true;
        } catch (PDOException $e) {
            throw new \RuntimeException("Error executing statement: " . $e->getMessage());
        }
    }

    public function deleteRecord(string $tableName, string $fieldName, mixed $fieldValue): bool
    {
        $sql_query = "DELETE FROM $tableName WHERE $fieldName = ?";

        try {
            $this->executeQuery(sql: $sql_query, params: [$fieldValue]);
            return true;
        } catch (PDOException $e) {
            throw new \RuntimeException("Error executing statement: " . $e->getMessage());
        }
    }

    public function retrieveTableReport(string $tableName, array $tableFields, array $joins, array $joinConditions): array
    {
        $fieldNames = implode(", ", $tableFields);

        $joinStatements = "";
        foreach ($joins as $index => $join) {
            $joinType = $join['type'];
            $joinTable = $join['table'];
            $joinCondition = $joinConditions[$index];
            $joinStatements .= "$joinType JOIN $joinTable ON $joinCondition ";
        }

        $sql_query = "SELECT $fieldNames FROM $tableName $joinStatements";

        try {
            $stmt = $this->executeQuery(sql: $sql_query);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            throw new \RuntimeException("Error executing statement: " . $e->getMessage());
        }
    }
}
