<?php

declare(strict_types=1);

namespace Marussia\Router;

use Marussia\Router\Exceptions\RouteIsNotFoundForNameException;

class Mapper
{
    private $uri;
    
    private $method;
    
    private $pattern;
    
    private $conditions;
    
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
    
    // Метод которыы будет стоять в конце каждой цепочки и собирать matched
    public function match() : void
    {
        if (preg_match($condition, $uri)) {
            
        }
    }
    
    public function getUrl(string $routeName, array $params = []) : string
    {

    }
    
    private function buildUrl(Matched $matched, array $params) : string
    {
    
    }
}
