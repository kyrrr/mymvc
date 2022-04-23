<?php

require_once dirname(__DIR__) . "/vendor/autoload.php";
require_once dirname(__DIR__) . "/bootstrapEnv.php";
require_once dirname(__DIR__) . "/doRoute.php";
require_once dirname(__DIR__) . "/autowire.php";

use KMVC\Util\Response;

$parts = parse_url($_SERVER['REQUEST_URI']);

if ( !isset( $routes[$parts['path']] ) ) {
    header("HTTP/1.1 404 Not Found");
    echo "No such route: " . $parts['path'];
    exit();
}

$container = new KMVC\Util\Container();
$route = $routes[$parts['path']];
$controller = $route['controller'];
$method = $route['method'];

$params = getConstructorParams($class=$controller);

$result = ((new $controller(...populateParams($params, $class, $container)))->{$method}());

if ( $result instanceof Response ) {
    $result->send();
}
