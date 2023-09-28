<?php

declare(strict_types=1);

namespace src\Model;

use src\Utils\DbGateway;
use src\Db\DbTable;
use PDOStatement;

class AdminModel
{
    protected array $databaseNames = ['movies', 'backup']; // Contains a list of all databases for the library
    protected DbTable $dbTable;

    public function __construct(private ?string $databaseName)
    {
        // Check if the provided database name is valid
        if ($databaseName !== null && !in_array($databaseName, $this->databaseNames)) {
            throw new \InvalidArgumentException("Invalid database name provided.");
        }

        // Will use a custom database name if provided; otherwise, defaults to "null"
        $this->databaseName = $databaseName ?? $this->databaseName;

        // Obtains the DbTableOp connection object using DbResource
        $this->dbTable = DbGateway::getTableConnection($this->databaseName);
    }

    public function createTable(string $tableName, string $fieldNames): PDOStatement
    {
        if (empty($tableName)) {
            throw new \InvalidArgumentException("No table name specified; kindly provide a valid table name.");
        }

        if (empty($fieldNames)) {
            throw new \InvalidArgumentException("No field names specified; kindly provide fieldnames required.");
        }

        return $this->dbTable->createTable(tableName: $tableName, fieldNames: $fieldNames);
    }

    public function alterTable(string $tableName, string $alterStatement): PDOStatement
    {
        if (empty($tableName)) {
            throw new \InvalidArgumentException("No table name specified; kindly provide a valid table name.");
        }

        if (empty($alterStatement)) {
            throw new \InvalidArgumentException("No alter statement specified; kindly provide required change statement to alter table.");
        }

        return $this->dbTable->alterTable(tableName: $tableName, alterStatement: $alterStatement);
    }

    public function truncateTable(string $tableName): PDOStatement
    {
        if (empty($tableName)) {
            throw new \InvalidArgumentException("No table name specified; kindly provide a valid table name.");
        }

        return $this->dbTable->truncateTable(tableName: $tableName);
    }

    public function dropTable(string $tableName): PDOStatement
    {
        if (empty($tableName)) {
            throw new \InvalidArgumentException("No table name specified; kindly provide a valid table name.");
        }

        return $this->dbTable->dropTable(tableName: $tableName);
    }
}
