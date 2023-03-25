<?php

namespace App\Exceptions;

use Illuminate\Support\Exceptions\MathException;

class NegativeNumberException extends MathException
{
    protected $message = 'The value must be a number greater than zero.';
    protected $code = 400;
}
