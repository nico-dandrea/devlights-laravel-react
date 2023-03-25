<?php

namespace App\Exceptions;

use Exception;

class InvalidPropertyNameException extends Exception
{
    protected $message = 'The property name is not valid.';
    protected $code = 400;
}
