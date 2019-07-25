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
        
        $matched = $this->getMatched();
        
        $result = Result::create(true);
        $result->handler = $matched->handler;
        $result->action = $matched->action;
        $result->attributes = $this->assignPlaceholders($matched->where, $matched->pattern);
    }
    
    private function prepareRoutes()
    {
        if (empty($this->routesDirPath)) {
            throw new \Exception('Routes directory path is not seted');
        }
        
        $this->segments = explode('/', $this->request->getUri());
        
        Route::plug($this->segments[0]);
    }
    
    private function assignPlaceholders(array $where, string $pattern) : array
    {
        $params = function () use ($where) {
            foreach ($where as $key => $value) {
                yield $key => $value;
            }
        };
        
        $attributes = [];
        
        $patternSegments = explode('/', $pattern);
        
        foreach ($patternSegments as $key => $segment) {
            
            $value = $params->current();
            $name = $params->key();
            
            $placeholder = str_replace('{$' . $name . '}');
            
            if ($placeholder !== $segment) {
                continue;
            }
            
            $attribute = $this->segments[$key];
            
            if (preg_match("($value)", $attribute, $property)) {
                $attributes[$name] = $property[0];
                $params->next();
            }
            
        }
        return $attributes;
    }

}
