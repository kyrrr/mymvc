<?php

use KMVC\Attribute\Singleton;
use KMVC\Exception\UnknownClass;
use KMVC\Util\Container;

function getConstructorParams(string $class):array{
    $reflection = new \ReflectionClass($class);
    $constructor = $reflection->getConstructor();
    return $constructor?->getParameters() ?? [];
}

function populateParams(array $params, string $className, Container &$container):array{
    $constructorArgs = [];
    foreach ($params as $param) {

        /** @var ReflectionNamedType $type */
        $type = $param->getType();
        $index = $param->getPosition();
        if ( $type->isBuiltin() ) {
            if ( $param->isDefaultValueAvailable() ) {
                $constructorArgs[$index] = $param->getDefaultValue();
            }
        } else {
            $class = $type->getName();

            if ( !class_exists($class) ) {
                throw new UnknownClass("Cannot inject into {$className}. "
                    . "Unknown class {$class} at position {$index}.");
            }

            $isSingleton = isset((new ReflectionClass($class))->getAttributes((Singleton::class))[0]);

            if ( $isSingleton && $container->exists($class) ) {
                $constructorArgs[$index] = $container->get($class);
                continue;
            }

            $newParams = populateParams(getConstructorParams($class), $class, $container);
            $instance = new $class(...$newParams);
            $constructorArgs[$index] = $instance;

            if ( $isSingleton ) {
                $container->set($instance);
            }
        }
    }
    return $constructorArgs;
}
