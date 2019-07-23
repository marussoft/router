<?php

declare(strict_types=1);

namespace Marussia\Router;

use Marussia\Router\Exceptions\RouteIsNotFoundForNameException;

class Mapper
{
    private $uri;
    
    private $method;
    
    public function setUri(string $uri) : self
    {
        $this->uri = $uri;
        return $this;
    }
    
    public function setMethod(string $method) : self
    {
        $this->method = strtolower($method);
        return $this;
    }
    
    public function getRoute(string $method, string $uri) :? Route
    {
        $routes = $this->storage->getRoutes($method);
        
        foreach ($routes as $route) {
            echo $route->condition;
            echo '<br>';
            echo $uri;
            if (preg_match($route->condition, $uri)) {
                return $route;
            }
        }
        return null;
    }
    
    public function getUrl(string $routeName, array $params = []) : string
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
