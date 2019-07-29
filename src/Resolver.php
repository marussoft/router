<?php

declare(strict_types=1);

namespace Marussia\Router;

use Marussia\Router\Contracts\RequestInterface;

class Resolver
{
    private $mapper;
    
    private $request;
    
    private $segments = [];
    
    private $matched;

    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
        Route::setHandler($mapper);
    }
    
    public function resolve() : Result
    {
        $this->prepareRoutes();
        
        return $this->buildResult();
    }
    
    public function setRequest(RequestInterface $request) : void
    {
        $this->request = $request;
        $this->mapper->setRequest($request);
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
    
    private function prepareRoutes() : void
    {
        $uri = $this->request->getUri();
        
        if (empty($uri) or $uri === '/') {
            Route::plug();
            return;
        }
        
        $this->segments = explode('/', $this->request->getUri());
        
        Route::plug($this->segments[0]);
    }
    
    private function assignAttributes(array $where, string $pattern) : array
    {
        $segments = explode('/', $pattern);
        
        $attributes = [];
    
        foreach ($where as $key => $value) {
        
            $placeholder = '{$' . $key . '}';
            
            $segmentKey = array_search($placeholder, $segments);
            
            $attribute = $this->segments[$segmentKey];
            
            if (preg_match("($value)", $attribute, $property)) {
                $attributes[$key] = $property[0];
            }
        }
        return $attributes;
    }

}
