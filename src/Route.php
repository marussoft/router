<?php

declare(strict_types=1);

namespace Marussia\Router;

class Route
{
    private static $mapper;
    
    public static function setMapper(Mapper $mapper)
    {
        static::$mapper = $mapper;
    }
    
    public static function get(string $pattern)
    {
        static::$mapper->match('get', $pattern);
        return ststic::$mapper;
    }
    

}
