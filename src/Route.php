<?php

declare(strict_types=1);

namespace Marussia\Router;

use Marussia\Router\Contracts\RouteHandlerInterface;

class Route
{
    protected static $handler = null;

    protected static $routesDirPath = '';

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
}
