<?php

namespace ZCredit\Exceptions;

use Exception;

class ZCreditException extends Exception
{
    public function __construct($message, Exception $previous = null)
    {
        if ($previous == null) {
            parent::__construct($message, $code=0, $previous);
        } else {
            parent::__construct($message, $previous->code, $previous);
        }
    }
}
