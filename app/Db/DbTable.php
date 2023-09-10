<?php

declare(strict_types=1);

namespace app\Db;

use PDO;
use PDOStatement;
use PDOException;

class DbTable
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Executes an SQL query and returns the PDOStatement.
     * 
     * @param string $sql The SQL query to execute.
     * @param array $params The parameters to bind to the query (optional).
     * @return PDOStatement The PDOStatement object.
     */
    protected function executeQuery(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * @param string $tableName = "Name of table to be created in database"
     * @param string $fieldNames = "fieldName dataType NULL/NOT NULL ?PRIMARY KEY ?AUTO_INCREMENT, fieldName dataType NULL/NOT NULL ?DEFAULT"
     * @return bool True if the table was created successfully, false otherwise
     */
    public function createTable(string $tableName, string $fieldNames): bool
    {
        $sql = "CREATE TABLE $tableName ($fieldNames)";
        try {
            $this->executeQuery(sql: $sql);
            return true;
        } catch (PDOException $e) {
            throw new \RuntimeException("Error! Table Creation Failed: " . $e->getMessage());
        }
    }

    /**
     * @param string $tableName Name of the table to be altered in the database
     * @param string $alterStatement Statement to modify the table structure
     * @return bool True if the table was altered successfully, false otherwise
     */
    public function alterTable(string $tableName, string $alterStatement): bool
    {
        $sql = "ALTER TABLE $tableName $alterStatement";
        try {
            $this->executeQuery(sql: $sql);
            return true;
        } catch (PDOException $e) {
            throw new \RuntimeException("Error! Process Failed: " . $e->getMessage());
        }
    }


    /**
     * @param string $tableName Name of the table to be truncated in the database
     * @return bool True if the table was truncated successfully, false otherwise
     */
    public function truncateTable(string $tableName): bool
    {
        $sql = "TRUNCATE TABLE $tableName";
        try {
            $this->executeQuery(sql: $sql);
            return true;
        } catch (PDOException $e) {
            throw new \RuntimeException("Error! Process Failed: " . $e->getMessage());
        }
    }

    /**
     * @param string $tableName Name of the table to be dropped in the database
     * @return bool True if the table was dropped successfully, false otherwise
     */
    public function dropTable(string $tableName): bool
    {
        $sql = "DROP TABLE $tableName";
        try {
            $this->executeQuery(sql: $sql);
            return true;
        } catch (PDOException $e) {
            throw new \RuntimeException("Error! Process Failed: " . $e->getMessage());
        }
    }
}
