<?php

declare(strict_types=1);

namespace Marussia\Router;

class Matched
{
    public $name;
    
    public $pattern;
    
    public $handler;
    
    public $action;
    
    public $method;
    
    public $where;
    
    public static function create(array $fillable) : self
    {
        $matched = new static();
        $matched->name = $fillable['name'];
        $matched->pattern = $fillable['pattern'];
        $matched->handler = $fillable['handler'];
        $matched->action = $fillable['action'];
        $matched->method = $fillable['method'];
        $matched->where = $fillable['where'] ?? '';
        return $matched;
    }
}
 
