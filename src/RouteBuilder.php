<?php

declare(strict_types=1);

namespace Marussia\Router;

class RouteBuilder
{
    private static $storage;

    public static function setStorage(Storage $storage)
    {
        static::$storage = $storage;
    }

    public static function get(string $condition) : Route
    {
        return static::register('get', $condition);
    }
    
    public static function post(string $condition) : Route
    {
        return static::register('post', $condition);
    }
    
    public static function put(string $condition) : Route
    {
        return static::register('put', $condition);
    }
    
    public static function patch(string $condition) : Route
    {
        return static::register('patch', $condition);
    }
    
    public static function delete(string $condition) : Route
    {
        return static::register('delete', $condition);
    }
    
    private static function register(string $method, string $condition) : Route
    {
        $route = Route::create($method, $condition);
        static::$storage->register($route);
        return $route;
    }
    
}
