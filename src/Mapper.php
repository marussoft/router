<?php

declare(strict_types=1);

namespace Marussia\Router;

use Marussia\Router\Exceptions\RouteIsNotFoundForNameException;

class Mapper
{
    private $uri;
    
    private $method;
    
    private $fillable;
    
    private $matched = null;
    
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
    
    public function route(string $method, string $pattern)
    {
        $this->fillable['method'] = $method;
        $this->fillable['pattern'] = $pattern;
    }
    
    public function where(array $where)
    {
        if (!preg_match('(\{\$[a-z]+\})', $this->fillable['pattern'])) {
            throw new PlaceholdersForPatternNotFound($this->fillable['pattern']);
        }
    
        foreach($where as $key => $condition) {
            $this->fillable['condition'] = str_replace('{' . $key . '}', $condition, $this->fillable['pattern']);
        }
    }
    
    public function name(string $name)
    {
        $this->fillable['name'] = $name;
    }
    
    // Метод которыы будет стоять в конце каждой цепочки и собирать matched
    public function match() : void
    {
        if (preg_match($this->fillable['condition'], $this->uri)) {
            $matched = Matched::create();
        }
    }
    
    public function getUrl(string $routeName, array $params = []) : string
    {

    }
    
    private function buildUrl(Matched $matched, array $params) : string
    {
    
    }
}
