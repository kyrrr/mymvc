<?php


namespace KMVC\Util;


class Container
{
    protected array $classList = [];

    public function exists(string $class):bool
    {
        return isset($this->classList[$class]);
    }

    public function set(object $object):bool
    {
        if ( !$this->exists($c=get_class($object)) ) {
            $this->classList[$c] = $object;
            return true;
        }
        return false;
    }

    public function get(string $class):object
    {
        return $this->classList[$class];
    }

    public function all():array
    {
        return $this->classList;
    }
}