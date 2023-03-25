<?php

namespace App\Exceptions;

use Exception;

class InvalidPriceException extends Exception
{
    protected $message = 'The price is not a valid number.';
    protected $code = 400;
}
