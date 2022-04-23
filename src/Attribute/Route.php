<?php

namespace KMVC\Attribute;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class Route
{
    public function __construct(protected string $path){}    

    public function getPath():string{
        return $this->path;
    }
}