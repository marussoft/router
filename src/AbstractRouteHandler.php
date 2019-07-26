<?php

declare(strict_types=1);

namespace Marussia\Router;

abstract class AbstractRouteHandler
{
    private $matched = null;

    public function route(string $method, string $pattern) : self
    {
        $this->matched = null;
        if (!is_null($this->matched)) {
            return $this;
        }
        $this->fillable['method'] = $method;
        $this->fillable['pattern'] = $pattern;
        return $this;
    }
    
    public function where(array $where) : self
    {
        if (!is_null($this->matched)) {
            return $this;
        }
        $this->fillable['where'] = $where;
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
        $this->checkErrors();
    
        if (!is_null($this->matched)) {
            return;
        }
    }
    
    public function isMatched() : bool
    {
        if (is_null($this->matched)) {
            return false;
        }
        return true;
    }
    
    public function checkErrors()
    {
        if (isset($this->fillable['where']) && !preg_match('(\{\$[a-z]+\})', $this->fillable['pattern'])) {
            throw new PlaceholdersForPatternNotFound($this->fillable['pattern']);
        }
        
        if (!isset($this->fillable['handler'])) {
            throw new HandlerIsNotSetedException($this->fillable['pattern']);
        }
    }
    
    public function __call()
    {
        return $this;
    }
}
