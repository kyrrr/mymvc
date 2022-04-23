<?php

declare(strict_types=1);

if ( php_sapi_name() !== "cli" ) {
    echo "Only cli plz!" . PHP_EOL;
    exit(1);
}

require "vendor/autoload.php";

use Bungle\Exception\BadConfig;
use Bungle\Exception\MissingParam;
use Bungle\Exception\UnknownClass;
use Bungle\Exception\UnknownController;
use Bungle\Exception\UnknownFunction;
use Bungle\Util\Container;

try {
    require "./bootstrapEnv.php";
    require "./autowire.php";

    array_shift($argv);

    $controller = $argv[0] ?? throw new MissingParam("Missing first parameter 'controller'");
    $functionName = $argv[1] ?? throw new MissingParam("Missing second parameter 'function'");

    array_shift($argv);
    array_shift($argv);

    $controllerName = "Bungle\Controller\\" . ucfirst($controller) . "Controller";

    if ( !class_exists($controllerName) ) {
        throw new UnknownController("Unknown controller $controllerName");
    } else if ( !method_exists($controllerName, $functionName) ) {
        throw new UnknownFunction("Unknown function $functionName");
    }

    $container = new Container();

    $params = populateParams(getConstructorParams($controllerName), $controllerName, $container);
    ((new $controllerName(...($params)))->{$functionName}(...$argv))->send();

} catch (ReflectionException|BadConfig|MissingParam|UnknownController|UnknownFunction|UnknownClass|TypeError $e) {
    echo $e->getMessage() . "({$e->getCode()})" . PHP_EOL;
    exit($e->getCode());
}


