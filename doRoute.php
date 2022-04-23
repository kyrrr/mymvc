<?php

$namespace = "KMVC\\Controller";
$routedPath = "../src/Controller";

function iterateRoutedDirectory(string $path, string $namespace):array
{
    $dirIterator = new RecursiveDirectoryIterator($path);
    $iterator = new RecursiveIteratorIterator($dirIterator);
    $routes = [];
    foreach ( $iterator as $it ) {
        if ( $it->isFile() && mb_strtolower($it->getExtension()) === "php" ) {
            $className = preg_replace("/\.php/", "", $it->getFileName());
            $routes[] = getControllerRoutes("\\" . $namespace . "\\" . $className);
        }
    }

    foreach ( $routes as $controllerIndex => $routes ) {
        foreach ( $routes as $path => $routeInfo ) {
            $flatRoutes[$path] = $routeInfo;
        }
    }
    return $flatRoutes ?? [];
}

function getControllerRoutes(string $class):array
{
    $routes = [];
    $ref = new ReflectionClass($class);
    $classRoute = $ref->getAttributes(\KMVC\Attribute\Route::class)[0] ?? null;

    $classPrefix = "";
    if ( $classRoute ) {
        $classPrefix = $classRoute->newInstance()->getPath();
    }

    $methods = $ref->getMethods();
    foreach ( $methods as $method ) {
        $methodRoute = $method->getAttributes(\KMVC\Attribute\Route::class)[0] ?? null;
        if ( $methodRoute ) {
            $fullRoute = $classPrefix . $methodRoute->newInstance()->getPath();
            $routes[$fullRoute] = [
                'controller' => $class,
                'method' => $method->getName()
            ];
        }
    }
    return $routes;
}

$routes = iterateRoutedDirectory($routedPath, $namespace);

