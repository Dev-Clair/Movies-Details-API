<?php

namespace app\Exception;

use Exception;

class ResourceNotFoundException extends Exception
{
    protected $message = 'Resource Not Found';
}
