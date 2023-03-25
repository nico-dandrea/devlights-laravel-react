<?php

namespace App\Exceptions;

use Exception;

class InvalidQueryException extends Exception
{
    protected $message = 'The query is not valid.';
    protected $code = 400;
}
