<?php

declare(strict_types=1);

namespace Marussia\Router;

use Marussia\Router\Exceptions\RouteIsNotFoundForNameException;

class Mapper
{
    private $storage;
    
    private $routesDirPath;
    
    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }
    
    public function getRoute(string $method, string $uri) :? Route
    {
        $routes = $this->storage->getRoute($method);
        
        foreach ($routes as $route) {
            if (preg_match($route->condition, $uri)) {
                return $route;
            }
        }
    }
    
    public function getUrl(string $routeName, array $params) : string
    {
        if ($this->storage->has($routeName)) {
            $route = $this->storage->get($routeName);
        } else {
            try {
                require_once $this->routesDirPath . array_shift(explode('.', $routeName));
            } catch (\Throwable $e) {
                throw $e;
            }
            
            if (!$this->storage->has($routeName)) {
                throw new RouteIsNotFoundForNameException($routeName);
            }
        }
        return $this->buildUrl($route, $params);
    }
    
    private function buildUrl(Route $route, array $params) : string
    {
    
    }
}
