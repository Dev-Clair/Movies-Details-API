<?php

declare(strict_types=1);

namespace src\Db;

use PDO;
use PDOStatement;

class DbTable
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Begin a transaction.
     */
    protected function beginTransaction()
    {
        $this->conn->beginTransaction();
    }


    /**
     * Commit the current transaction.
     */
    protected function commit()
    {
        $this->conn->commit();
    }


    /**
     * Rollback the current transaction.
     */
    protected function rollback()
    {
        $this->conn->rollBack();
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
     * @param string $tableName Name of table to be created in database
     * @param string $fieldNames 
     * @return bool True if the table was created successfully, false otherwise
     */
    public function createTable(string $tableName, string $fieldNames): PDOStatement
    {
        $sql = "CREATE TABLE $tableName ($fieldNames)";

        $query_result = $this->executeQuery(sql: $sql);
        return $query_result;
    }


    /**
     * @param string $tableName Name of the table to be altered in the database
     * @param string $alterStatement Statement to modify the table structure
     * @return bool True if the table was altered successfully, false otherwise
     */
    public function alterTable(string $tableName, string $alterStatement): PDOStatement
    {
        $sql = "ALTER TABLE $tableName $alterStatement";

        $query_result = $this->executeQuery(sql: $sql);
        return $query_result;
    }


    /**
     * @param string $tableName Name of the table to be truncated in the database
     * @return bool True if the table was truncated successfully, false otherwise
     */
    public function truncateTable(string $tableName): PDOStatement
    {
        $sql = "TRUNCATE TABLE $tableName";

        $query_result = $this->executeQuery(sql: $sql);
        return $query_result;
    }


    /**
     * @param string $tableName Name of the table to be dropped in the database
     * @return bool True if the table was dropped successfully, false otherwise
     */
    public function dropTable(string $tableName): PDOStatement
    {
        $sql = "DROP TABLE $tableName";

        $query_result = $this->executeQuery(sql: $sql);
        return $query_result;
    }
}
