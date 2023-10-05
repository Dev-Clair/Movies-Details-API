<?php

declare(strict_types=1);

namespace src\Model;

use src\Db\DbGateway;
use src\Db\DbTable;
use PDOStatement;
use src\Interface\ModelInterface;

class AdminModel implements ModelInterface
{
    protected DbTable $dbTable;
    protected ?string $databaseName = "";

    public function __construct(protected DbGateway $dbGateWay, ?string $databaseName)
    {
        $this->databaseName = $databaseName ?? $this->databaseName;

        // Obtains the DbTable connection object via the DbGateWay Class
        $this->dbGateWay = new DbGateWay;
        $this->dbTable = $this->dbGateWay->getTableConnection($this->databaseName);
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
