<?php


namespace KMVC\Exception;


use Throwable;

class UnknownClass extends \InvalidArgumentException
{
    public function __construct($message = "", $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}