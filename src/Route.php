<?php

declare(strict_types=1);

namespace Marussia\Router;

class Route
{
    public static $uri;
    private static $controller = '';
    private static $action = '';
    private static $nesting;
    private static $alias;
    private static $routes;
    
    
    public static function add(string $controller, string $action, string $route, array $routes = [], bool $nesting = false, bool $alias = false) : void
    {
        // Сравниваем $route из роутов с uri
        if (empty(static::$controller) && preg_match("($route)", static::$uri)) {
            static::$routes = $routes;
            static::$controller = $controller;
            static::$action = $action;
            static::$nesting = $nesting;
            static::$alias = $alias;
        }
    }

    public static function controller()
    {
        return static::$controller;
    }
    
    public static function action()
    {
        return static::$action;
    }
    
    public static function routes()
    {
        return static::$routes;
    }
    
    public static function nesting()
    {
        return static::$nesting;
    }
    
    public static function alias()
    {
        return static::$alias;
    }
    
}
