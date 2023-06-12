<?php

namespace App\Exceptions;

use App\Models\Collector;
use Exception;

class CollectorException extends Exception
{
    //
    function __construct($message, $error, Collector $collector = null)
    {
        parent::__construct($message);
    }
}
