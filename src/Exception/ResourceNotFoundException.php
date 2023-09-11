<?php

namespace src\Exception;

use Exception;

class ResourceNotFoundException extends Exception
{
    protected $message = 'Resource Not Found';
}
