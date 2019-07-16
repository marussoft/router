<?php

declare(strict_types=1);

namespace Marussia\Router;

class Route
{
    public $name;
    
    public $nesting;
    
    public $handler;
    
    public $action;
    
    public $alias;
    
    public $method;
    
    public $conditions;
    
    public function __construct(string $method)
    {
        $this->method = $method;
    }
    
    public function handler(string $handler)
    {
        $this->handler = $handler;
    }
    
    public function action(string $action)
    {
        $this->action = $action;
    }
    
    public function alias($alias)
    {
        $this->alias = $alias;
    }
    
    public function nesting($nesting)
    {
        $this->nesting = $nesting;
    }
    
    public function where(array $conditions) : self
    {
        $this->conditions = $conditions;
        return $this;
    }
    
    public function name(string $name) : self
    {
        $this->name = $name;
        return $this;
    }
}
