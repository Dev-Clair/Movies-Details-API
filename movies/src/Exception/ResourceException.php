<?php

namespace src\Exception;

use RuntimeException;

class ResourceException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct();
    }
}
