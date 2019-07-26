<?php

declare(strict_types=1);

namespace Marussia\Router;

use Marussia\Router\Exceptions\RouteNotFoundException;

class Resolver
{
    private $mapper;
    
    private $request;
    
    private $segments = [];
    
    private $matched;

    public function __construct(Request $request, Mapper $mapper)
    {
        $this->mapper = $mapper;
        $this->request = $request;
        Route::setHandler($mapper);
    }
    
    public function resolve() : Result
    {
        $this->prepareRoutes();
        
        return $this->buildResult();
    }
    
    private function buildResult() : Result
    {
        if (!$this->mapper->isMatched()) {
            return Result::create(false);
        }
        
        $matched = $this->mapper->getMatched();
        
        $result = Result::create(true);
        $result->handler = $matched->handler;
        $result->action = $matched->action;
        if (!empty($matched->where)) {
            $result->attributes = $this->assignAttributes($matched->where, $matched->pattern);
        }
        return $result;
    }
    
    private function prepareRoutes()
    {
        $this->segments = explode('/', $this->request->getUri());
        
        Route::plug($this->segments[0]);
    }
    
    private function assignAttributes(array $where, string $pattern)
    {
        $segments = explode('/', $pattern);
        
        $attributes = [];
    
        foreach ($where as $key => $value) {
            $placeholder = str_replace($key, '{$' . $key . '}', $key);
            
            $segmentKey = array_search($placeholder, $segments);
            
            $attribute = $this->segments[$segmentKey];
            
            if (preg_match("($value)", $attribute, $property)) {
                $attributes[$key] = $property[0];
            }
        }
        return $attributes;
    }

}
