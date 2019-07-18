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
    
    public $where;
    
    public function __construct(string $method, string $condition) // технический долг. В conditiob нужно класть готовую регулярку
    {
        $this->method = $method;
        $this->condition = $condition;
    }
    
    public static function create(string $method, string $condition)
    {
        return new self($method, $condition);
    }
    
    public function handler(string $handler)
    {
        $this->handler = $handler;
        return $this;
    }
    
    public function action(string $action)
    {
        $this->action = $action;
        return $this;
    }
    
    public function alias($alias)
    {
        $this->alias = $alias;
        return $this;
    }
    
    public function nesting($nesting)
    {
        $this->nesting = $nesting;
        return $this;
    }
    
    public function where(array $where) : self
    {
        $this->where = $where;
        return $this;
    }
    
    public function name(string $name) : self
    {
        $this->name = $name;
        return $this;
    }
}
