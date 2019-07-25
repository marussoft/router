<?php

declare(strict_types=1);

namespace Marussia\Router;

class Matched
{
    private $name;
    
    private $pattern;
    
    private $handler;
    
    private $action;
    
    private $method;
    
    private $conditions;
    
    private $where;
    
    public static function create(array $fillable) : self
    {
        return new static();
    }
}
 
