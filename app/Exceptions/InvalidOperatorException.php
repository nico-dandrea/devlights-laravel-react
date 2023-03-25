<?php

namespace App\Exceptions;

use Exception;

class InvalidOperatorException extends Exception
{
    protected $message = 'The operator is not valid for this attribute.';
    protected $code = 400;
}
