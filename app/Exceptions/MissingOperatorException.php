<?php

namespace App\Exceptions;

use Exception;

class MissingOperatorException extends Exception
{
    protected $message = 'The string does not contain an operator.';
    protected $code = 400;
}
