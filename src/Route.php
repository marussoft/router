<?php

declare(strict_types=1);

namespace Marussia\Router;

class Route
{
    private static $uri;
    private static $controller = '';
    private static $action = '';
    private static $nesting;
    private static $alias;
    private static $routes;
    private static $method;
    
    
    public static function get(string $controller, string $action, string $route, array $routes = [], bool $nesting = false, bool $alias = false) : void
    {
        if (static::$method !== 'GET') {
            return;
        }
    
        // Сравниваем $route из роутов с uri
        if (empty(static::$controller) && preg_match("($route)", static::$uri)) {
            static::$routes = $routes;
            static::$controller = $controller;
            static::$action = $action;
            static::$nesting = $nesting;
            static::$alias = $alias;
        }
    }
    
    public static function post(string $controller, string $action, string $route, array $routes = [], bool $nesting = false, bool $alias = false) : void
    {
        if (static::$method !== 'POST') {
            return;
        }
    
        // Сравниваем $route из роутов с uri
        if (empty(static::$controller) && preg_match("($route)", static::$uri)) {
            static::$routes = $routes;
            static::$controller = $controller;
            static::$action = $action;
            static::$nesting = $nesting;
            static::$alias = $alias;
        }
    }
    
    public static function put(string $controller, string $action, string $route, array $routes = [], bool $nesting = false, bool $alias = false) : void
    {
        if (static::$method !== 'PUT') {
            return;
        }
    
        // Сравниваем $route из роутов с uri
        if (empty(static::$controller) && preg_match("($route)", static::$uri)) {
            static::$routes = $routes;
            static::$controller = $controller;
            static::$action = $action;
            static::$nesting = $nesting;
            static::$alias = $alias;
        }
    }
    
    public static function delete(string $controller, string $action, string $route, array $routes = [], bool $nesting = false, bool $alias = false) : void
    {
        if (static::$method !== 'DELETE') {
            return;
        }
    
        // Сравниваем $route из роутов с uri
        if (empty(static::$controller) && preg_match("($route)", static::$uri)) {
            static::$routes = $routes;
            static::$controller = $controller;
            static::$action = $action;
            static::$nesting = $nesting;
            static::$alias = $alias;
        }
    }
    
    public static function patch(string $controller, string $action, string $route, array $routes = [], bool $nesting = false, bool $alias = false) : void
    {
        if (static::$method !== 'PATCH') {
            return;
        }
    
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
    
    public static function setMethod(string $method)
    {
        static::$method = $method;
    }
    
    public static function setUri(string $uri)
    {
        static::$uri = $uri;
    }
}
