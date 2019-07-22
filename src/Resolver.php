<?php

declare(strict_types=1);

namespace Marussia\Router;

use Marussia\Router\Exceptions\RouteNotFoundException;

class Resolver
{
    private $mapper;
    
    private $segments = [];

    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }
    
    public function setUri(string $uri) : void
    {
        $this->uri = $uri;
    }
    
    public function setMethod(string $method) : void
    {
        $this->method = strtolower($method);
    }
    
    public function startRouting(string $method, string $uri)
    {
        $this->segments = explode('/', $uri);
        
        if (count($this->segments) > 1) {
            $this->mapper->plugRoutes();
        }
        
        $route = $this->mapper->getRoute();
    }
}
 
