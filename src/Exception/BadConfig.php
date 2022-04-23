<?php


namespace KMVC\Exception;


use Throwable;

class BadConfig extends \Exception
{
    public function __construct($message = "", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}