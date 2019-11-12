<?php

declare(strict_types=1);

namespace Marussia\Router;

use Marussia\Router\Exceptions\PlaceholdersForPatternNotFoundException;
use Marussia\Router\Exceptions\HandlerIsNotSetException;
use Marussia\Router\Exceptions\ActionIsNotSetException;
use Marussia\Router\Contracts\RequestInterface;

abstract class AbstractRouteHandler
{
    protected $request;

    protected $matched = null;
    
    protected $fillable = [];

    protected $attributeTypes = [
        'STRING' => '([a-z0-9\-]+)',
        'INTEGER' => '([0-9]+)',
        'ARRAY' => '([a-z0-9]+)/(([a-z0-9\-]+/)+|([a-z0-9\-_]+)+)($)',
    ];
    
    const PLACEHOLDER_TYPE_STRING = 'STRING';

    const PLACEHOLDER_TYPE_INTEGER = 'INTEGER';

    const PLACEHOLDER_TYPE_ARRAY = 'ARRAY';
    
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
    
    public function match() : void
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
    
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
    }
    
    public function __call(string $name , array $arguments = []) : self
    {
        return $this;
    }
    
    protected function checkErrors() : void
    {
        if (isset($this->fillable['where']) && !preg_match('(\{\$[a-zA-Z]+\})', $this->fillable['pattern'])) {
            throw new PlaceholdersForPatternNotFoundException($this->fillable['pattern']);
        }
        
        if (!isset($this->fillable['handler'])) {
            throw new HandlerIsNotSetException($this->fillable['pattern']);
        }
        
        if (!isset($this->fillable['action'])) {
            throw new ActionIsNotSetException($this->fillable['pattern']);
        } 
    }
    
    public function getPlaceholderType(string $type) : string
    {
        return $this->attributeTypes[strtoupper($type)];
    }

    public function hasPlaceholderType(string $type) : bool
    {
        return array_key_exists(strtoupper($type), $this->attributeTypes);
    }
}
