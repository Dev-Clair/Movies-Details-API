<?php

namespace app\Exception;

use Exception;

class RouteNotFoundException extends Exception
{
    protected $message = '404 Not Found';
}
