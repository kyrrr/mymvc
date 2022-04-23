<?php

namespace KMVC\Controller;

use KMVC\Attribute\Route;

class FooController {
    #[Route(path:"/foo/bar")]
    public function foo(){}
}