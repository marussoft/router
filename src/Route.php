<?php

declare(strict_types=1);

namespace Marussia\Router;

use Marussia\Router\Contracts\RouteHandlerInterface;

class Route
{
    private static $handler = null;
    
    private static $routesDirPath = '';
    
    private const ROUTE_FILE_NAME = 'default';
    
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
    
    public static function plug(string $routesFileName = '') : void
    {
        if (empty(static::$routesDirPath)) {
            throw new \Exception('Routes directory path is not seted');
        }

        if (empty($routesFileName)) {
            require static::$routesDirPath . self::ROUTE_FILE_NAME . '.php';
            return;
        }
        
        if (is_file(static::$routesDirPath . $routesFileName . '.php')) {
            require static::$routesDirPath . $routesFileName . '.php';
            return;
        }
        require static::$routesDirPath . self::ROUTE_FILE_NAME . '.php';
    }
    
    public static function setRoutesDirPath(string $dirPath)
    {
        // @todo тут должно быть исключение если routesDirPath уже установлен
        if (empty(static::$routesDirPath)) {
            static::$routesDirPath = $dirPath;
        }
    }
}
