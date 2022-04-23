<?php


namespace KMVC\Exception;


use Throwable;

class UnknownController extends \InvalidArgumentException
{
    public function __construct($message = "", $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}