<?php


namespace KMVC\Attribute;

#[\Attribute(\Attribute::TARGET_CLASS)]
class Singleton
{
    public function __construct(){}
}