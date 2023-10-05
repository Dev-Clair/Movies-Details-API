<?php

declare(strict_types=1);

namespace src\Model;

use src\Db\DbGateway;
use src\Db\DbTableOp;
use src\Interface\ModelInterface;

abstract class MainModel implements ModelInterface
{
    protected DbTableOp $dbTableOp;

    public function __construct(protected DbGateway $dbGateWay, protected ?string $databaseName)
    {
        $this->initDb();
    }

    public function initDb()
    {
        $this->dbTableOp = $this->dbGateWay->getTableOPConnection($this->databaseName);
    }
}
