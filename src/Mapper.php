<?php

declare(strict_types=1);

namespace Marussia\Router;

use Marussia\Router\Contracts\RouteHandlerInterface;

class Mapper extends AbstractRouteHandler implements RouteHandlerInterface
{
    private $request;

    private $fillable = [];
    
    private $matched = null;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    public function match() : void
    {
        parent::match();
    
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
    
    public function getMatched() : Matched
    {
        return $this->matched;
    }

}
