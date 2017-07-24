<?php

namespace App\Exceptions;

use Exception;

class InvalidCartItemException extends Exception
{
    public function __construct($message = 'The CartItem is invalid', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
