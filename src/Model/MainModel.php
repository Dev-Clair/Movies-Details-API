<?php

declare(strict_types=1);

namespace src\Model;

use src\Db\DbConn;
use src\Interface\ModelInterface;

abstract class MainModel implements ModelInterface
{
    public function __construct(protected DbConn $dbConn)
    {
    }
}
