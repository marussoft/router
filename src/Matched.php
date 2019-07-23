<?php

declare(strict_types=1);

namespace Marussia\Router;

class Matched
{
    private $name;
    
    private $pattern;
    
    private $nesting;
    
    private $handler;
    
    private $action;
    
    private $alias;
    
    private $method;
    
    private $conditions;
    
    private $where;
    
    public function __construct() 
    {

    }
    
    public static function create() : self
    {
        return new static();
    }
}
 
