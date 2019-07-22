<?php

declare(strict_types=1);

namespace Marussia\Router;

use Marussia\Router\Exceptions\RouteIsNotFoundForNameException;
use Marussia\Router\Contracts\StorageInterface;

class Mapper
{
    private $storage;
    
    private $routesDirPath;
    
    private $uri;
    
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }
    
    public function setStorage(StorageInterface $storage) : void
    {
        $this->storage = $storage;
    }
    
    public function setRoutesDirPath(string $dirPath)
    {
        $this->routesDirPath = $dirPath;
    }
    
    public function getRoute(string $method, string $uri) :? Route
    {
        $routes = $this->storage->getRoutes($method);
        
        foreach ($routes as $route) {
            if (preg_match($route->condition, $uri)) {
                return $route;
            }
        }
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
