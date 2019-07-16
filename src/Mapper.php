<?php

declare(strict_types=1);

namespace Marussia\Router;

class Mapper
{
    private $storage;
    
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
    
    }
}
