<?php

declare(strict_types=1);

namespace src\Model;

use src\Interface\ModelInterface;
use InvalidArgumentException;

abstract class MainModel implements ModelInterface
{
    protected function invalid_arg_check(array $args)
    {
        foreach ($args as $argName => $argValue) {
            if (empty($argValue)) {
                throw new InvalidArgumentException("$argName is either null, false or not set.");
            }
        }
    }


    protected function arg_num_check(int $expectedArgs, int $suppliedArgs)
    {
        if ($expectedArgs !== $suppliedArgs) {
            throw new InvalidArgumentException("Invalid number of arguments supplied. Expected: $expectedArgs, Supplied: $suppliedArgs");
        }
    }
}
