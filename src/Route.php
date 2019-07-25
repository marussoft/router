<?php

declare(strict_types=1);

namespace Marussia\Router;

class Route
{
    private static $handler = null;
    
    private static const ROUTE_FILE_NAME = 'default';
    
    private static $routesDirPath = null;
    
    public static function setHandler(RouteHandlerInterface $handler)
    {
        static::$handler = $handler;
    }
    
    
    
    public static function get(string $pattern)
    {
        if (is_null(static::$handler)) {
            throw new \Exception('Router is not initialized');
        }
        
        return static::$handler->route('get', $pattern);
    }
    
    public static function post(string $pattern)
    {
        if (is_null(static::$handler)) {
            throw new \Exception('Router is not initialized');
        }
        
        return static::$handler->route('post', $pattern);
    }
    
    public static function put(string $pattern)
    {
        if (is_null(static::$handler)) {
            throw new \Exception('Router is not initialized');
        }
        
        return static::$handler->route('put', $pattern);
    }
    
    public static function patch(string $pattern)
    {
        if (is_null(static::$handler)) {
            throw new \Exception('Router is not initialized');
        }
        
        return static::$handler->route('patch', $pattern);
    }
    
    public static function delete(string $pattern)
    {
        if (is_null(static::$handler)) {
            throw new \Exception('Router is not initialized');
        }
        
        return static::$handler->route('delete', $pattern);
    }
    
    public static function plug(string $routesFileName)
    {
        try {
            require $this->routesDirPath . $routesFileName . '.php';
        } catch (\Throwable $e) {
            require $this->routesDirPath . self::ROUTE_FILE_NAME . '.php';
        }
    }
    
    public static function setRoutesDirPath(string $dirPath)
    {
        // @todo тут должно быть исключение если routesDirPath уже установлен
        if (!is_null(static::routesDirPath)) {
            static::$routesDirPath = $dirPath;
        }
    }
}
