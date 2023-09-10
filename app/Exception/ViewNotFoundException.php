<?php

namespace app\Exception;

use Exception;

class ViewNotFoundException extends Exception
{
    protected $message = 'View Not Found';
}
