<?php

declare(strict_types=1);

namespace app\Db;

use PDO;
use PDOException;

class DbConn
{
    private ?PDO $conn;

    /**
     * Constructor, initializes the connection settings.
     *
     * @param string $driver (e.g., "mysql", "pgsql", "sqlite", etc.).
     * @param string $serverName Server name (localhost) or IP address(remote host).
     * @param string $userName   Database username.
     * @param string $password   Database password.
     * @param string|null $database   Database name (optional).
     */
    public function __construct(private string $driver, private string $serverName, private string $userName, private string $password, private ?string $database = null)
    {
        $this->connect();
    }

    /**
     * Establishes resource: the database connection.
     */
    private function connect(): void
    {
        $dsn = "{$this->driver}:host={$this->serverName};dbname={$this->database};charset=utf8mb4";

        try {
            $this->conn = new PDO(dsn: $dsn, username: $this->userName, password: $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new \RuntimeException("Error! Connection Failed: " . $e->getMessage());
        }
    }

    /**
     * Retrieves resource: database connection object.
     * @return PDO|null Database connection object.
     */
    public function getConnection(): ?PDO
    {
        return $this->conn;
    }

    /**
     * Closes the resource: database connection.
     */
    public function closeConnection(): void
    {
        $this->conn = null;
    }
}
