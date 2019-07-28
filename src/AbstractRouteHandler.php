<?php

declare(strict_types=1);

namespace Marussia\Router;

use Marussia\Router\Exceptions\PlaceholdersForPatternNotFound;

abstract class AbstractRouteHandler
{
    protected $matched = null;

    public function route(string $method, string $pattern) : self
    {
        if (!is_null($this->matched)) {
            return $this;
        }
        
        $this->fillable = [];
        
        $this->fillable['method'] = $method;
        $this->fillable['pattern'] = $pattern;
        return $this;
    }
    
    public function where(array $where) : self
    {
        if (!is_null($this->matched)) {
            return $this;
        }
        if (!is_null($where)) {
            $this->fillable['where'] = $where;
        }
        return $this;
    }
    
    public function name(string $name) : self
    {
        if (!is_null($this->matched)) {
            return $this;
        }
        $this->fillable['name'] = $name;
        return $this;
    }
    
    public function handler(string $handler) : self
    {
        if (!is_null($this->matched)) {
            return $this;
        }
        $this->fillable['handler'] = $handler;
        return $this;
    }
    
    public function action(string $action) : self
    {
        if (!is_null($this->matched)) {
            return $this;
        }
        $this->fillable['action'] = $action;
        return $this;
    }
    
    public function match()
    {
        if (!is_null($this->matched)) {
            return;
        }
        $this->checkErrors();
    }
    
    public function isMatched() : bool
    {
        if (is_null($this->matched)) {
            return false;
        }
        return true;
    }
    
    protected function checkErrors()
    {
        if (isset($this->fillable['where']) && !preg_match('(\{\$[a-z]+\})', $this->fillable['pattern'])) {
            throw new PlaceholdersForPatternNotFound($this->fillable['pattern']);
        }
        
        if (!isset($this->fillable['handler'])) {
            throw new HandlerIsNotSetedException($this->fillable['pattern']);
        }
        
        if (!isset($this->fillable['action'])) {
            throw new ActionIsNotSetedException($this->fillable['pattern']);
        } 
    }
}
