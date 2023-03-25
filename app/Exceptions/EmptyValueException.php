<?php

namespace App\Exceptions;

use Exception;

class EmptyValueException extends Exception
{
    protected $message = 'The value is empty.';
    protected $code = 400;
}
