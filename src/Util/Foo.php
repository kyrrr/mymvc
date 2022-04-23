<?php

namespace KMVC\Util;

use KMVC\Util\Bar;
use KMVC\Attribute\Singleton;

#[Singleton]
class Foo {

    function __construct(protected Bar $bar){}

    public function bar():string{
        return "hello from controller dependency and " . $this->bar->foo();
    }
}