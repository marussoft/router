<?php

declare(strict_types=1);

namespace Marussia\Router;

use Marussia\Router\Contracts\RouteHandlerInterface;

class Mapper implements RouteHandlerInterface
{
    private $request;

    private $fillable = [];
    
    private $matched = null;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
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
    
    // Метод который должен стоять в конце каждой цепочки и собирать matched
    public function match() : void
    {
        $this->checkErrors();
    
        if (!is_null($this->matched)) {
            return;
        }

        if (!$this->request->isMethod(strtoupper($this->fillable['method']))) {
            return;
        }
   
        $pattern = $this->fillable['pattern'];
        
        // @todo добавить проверку на существование плейсхолдера с выбросом исключения (противоречит $this->checkErrors)
        if (!empty($this->fillable['where'])) {
            foreach($this->fillable['where'] as $key => $condition) {
                $pattern = str_replace('{$' . $key . '}', $condition, $pattern);
            }
        }

        if (!preg_match("(^$pattern$)", $this->request->getUri())) {
            return;
        }

        $this->matched = Matched::create($this->fillable);
    }
    
    public function isMatched() : bool
    {
        if (is_null($this->matched)) {
            return false;
        }
        return true;
    }
    
    public function getMatched() : Matched
    {
        return $this->matched;
    }
    
    private function checkErrors()
    {
        if (isset($this->fillable['where']) && !preg_match('(\{\$[a-z]+\})', $this->fillable['pattern'])) {
            throw new PlaceholdersForPatternNotFound($this->fillable['pattern']);
        }
        
        if (!isset($this->fillable['handler'])) {
            throw new HandlerIsNotSetedException($this->fillable['pattern']);
        }
    }
}
