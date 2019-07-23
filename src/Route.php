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
    
    public static function create(string $method, string $condition) : self
    {
        return new self($method, $condition);
    }
    
    public function handler(string $handler) : self
    {
        $this->handler = $handler;
        return $this;
    }
    
    public function action(string $action) : self
    {
        $this->action = $action;
        return $this;
    }
    
    public function alias($alias) : self
    {
        $this->alias = $alias;
        return $this;
    }
    
    public function nesting($nesting) : self
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
