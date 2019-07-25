<?php

declare(strict_types=1);

namespace Marussia\Router;

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
    
    public function action(string $action)
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
            $this->matched = [];
            return;
        }
        
        if ($this->request->getMethod() !== $this->fillable['method']) {
            $this->matched = [];
            return;
        }
    
        // @todo добавить проверку на существование плейсхолдера с выбросом исключения (противоречит $this->checkErrors)
        if (!empty($this->fillable['where'])) {
            foreach($this->fillable['where'] as $key => $condition) {
                $this->fillable['condition'] = str_replace('{$' . $key . '}', $condition, $this->fillable['pattern']);
            }
        }
        
        if (!preg_match($this->fillable['condition'], $this->request->getUri())) {
            $this->matched = [];
            return;
        }
        $this->matched = $matched = Matched::create($this->fillable);
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
