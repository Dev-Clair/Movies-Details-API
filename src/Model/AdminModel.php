<?php

declare(strict_types=1);

namespace src\Model;

use src\Db\DbConn;
use PDOStatement;
use src\Interface\ModelInterface;

class AdminModel implements ModelInterface
{
    public function __construct(protected DbConn $dbConn)
    {
    }

    public function createTable(string $tableName, string $fieldNames): PDOStatement
    {
        if (empty($tableName)) {
            throw new \InvalidArgumentException("No table name specified; kindly provide a valid table name.");
        }

        if (empty($fieldNames)) {
            throw new \InvalidArgumentException("No field names specified; kindly provide fieldnames required.");
        }

        return $this->dbConn->createTable(tableName: $tableName, fieldNames: $fieldNames);
    }

    public function alterTable(string $tableName, string $alterStatement): PDOStatement
    {
        if (empty($tableName)) {
            throw new \InvalidArgumentException("No table name specified; kindly provide a valid table name.");
        }

        if (empty($alterStatement)) {
            throw new \InvalidArgumentException("No alter statement specified; kindly provide required change statement to alter table.");
        }

        return $this->dbConn->alterTable(tableName: $tableName, alterStatement: $alterStatement);
    }

    public function truncateTable(string $tableName): PDOStatement
    {
        if (empty($tableName)) {
            throw new \InvalidArgumentException("No table name specified; kindly provide a valid table name.");
        }

        return $this->dbConn->truncateTable(tableName: $tableName);
    }

    public function dropTable(string $tableName): PDOStatement
    {
        if (empty($tableName)) {
            throw new \InvalidArgumentException("No table name specified; kindly provide a valid table name.");
        }

        return $this->dbConn->dropTable(tableName: $tableName);
    }
}
