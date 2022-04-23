<?php

namespace KMVC\Util;

class Response
{
    protected string $dataType;
    protected mixed $data;

    public function __construct(mixed $data)
    {
        $this->dataType = gettype($data);
        $this->data = $data;
    }

    public function getType():string{
        return $this->dataType;
    }

    public function send():void
    {
        switch ($this->getType()){
            case "string":
            case "int":
            case "float":
                echo $this->data;
                echo PHP_EOL;
                break;
            case "array":
                print_r($this->data);
                break;
            default:var_dump($this->data);
        }
    }
}