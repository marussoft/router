<?php

declare(strict_types=1);

namespace Marussia\Router;

use Marussia\Router\Exceptions\RouteIsExistException;
use Marussia\Router\Contracts\StorageInterface;

class Storage implements StorageInterface
{
    private $routes = [
        'get' => [],
        'post' => [],
        'put' => [],
        'patch' => [],
        'delete' => []
    ];
    
    private $byName = [];

    public function register(Route $route)
    {
        if ($this->has($route->name)) {
            throw new RouteIsExistException($route->name);
        }
        $this->routes[$route->method][$route->name] = $route;
        $this->byName[$route->name] = $route->method;
    }
    
    public function has(string $routeName) : bool
    {
        foreach($this->routes as $method) {
            if (array_key_exists($routeName, $method)) {
                return true;
            }
        }
        return false;
    }
    
    public function getRoutes(string $method) : array
    {
        return $this->byMethod[$method];
    }
    
    public function get(string $routeName) : Route
    {
        return $this->routes[$this->byName[$routeName]][$routeName];
    }
}
