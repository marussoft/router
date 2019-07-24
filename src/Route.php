<?php

declare(strict_types=1);

namespace Marussia\Router;

class Route
{
    private static $mapper = null;
    
    private static $generator = null;
    
    public static function setMapper(Mapper $mapper)
    {
        static::$mapper = $mapper;
    }
    
    private static function setGenerator(UrlGenerator $generator)
    {
        static::$generator = $generator;
    }
    
    public static function get(string $pattern)
    {
        if (is_null(static::$mapper)) {
            throw new \Exception('Router is not initialized');
        }
        
        static::$mapper->route('get', $pattern);
        return static::$mapper;
    }
    
    public static function getUrl(string $routeName, array $params)
    {
        static::$generator->getUrl($routeName, $params);
    }
}
