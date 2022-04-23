<?php


namespace KMVC\Controller;

use KMVC\Util\Response;
use KMVC\Attribute\Route;
use KMVC\Util\Foo;

class IndexController
{
    public function __construct(protected Foo $foo){}

    #[Route(path:"/")]
    public function hello():Response
    {
        return new Response([
            "message" => $this->foo->bar(),
            "env" => getenv("FOO")
        ]);
    }

    #[Route(path:"/test")]
    public function test():void{
        echo "hello";   
    }
}