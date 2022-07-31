<?php

namespace Brain\Injector\Facade;

use function DI\create;
use Brain\Injector\Container;

use DI\Definition\Helper\CreateDefinitionHelper;

class Injector
{

    private static $container;

    /**
     *
     * @param string $path
     * @return void
     */
    public static function init (string $path) : void
    {
        static::$container = (new Container($path))->getContainer();
    }
    
    /**
     *
     * @param string $class
     * @return CreateDefinitionHelper
     */
    public static function create (string $class) : CreateDefinitionHelper
    {
        return create($class);
    }

    /**
     *
     * @param string $methode
     * @param array $arguments
     * @return mixed
     */
    public static function __callStatic(string $methode, array $arguments)
    {
        return call_user_func_array([static::$container, $methode], $arguments);
    }
}
