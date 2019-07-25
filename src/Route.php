<?php

declare(strict_types=1);

namespace Marussia\Router;

class Route
{
    private static $mapper = null;
    
    public static function setMapper(Mapper $mapper)
    {
        static::$mapper = $mapper;
    }
    
    public static function get(string $pattern)
    {
        if (is_null(static::$mapper)) {
            throw new \Exception('Router is not initialized');
        }
        
        static::$mapper->route('get', $pattern);
        return static::$mapper;
    }
    

}
