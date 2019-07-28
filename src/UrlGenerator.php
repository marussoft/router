<?php

declare(strict_types=1);

namespace Marussia\Router;

use Marussia\Router\Contracts\RouteHandlerInterface;
use Marussia\Router\Exceptions\RouteIsNotFoundForNameException;
use Marussia\Router\Exceptions\PlaceholderIsNotFoundForRoute;

class UrlGenerator extends AbstractRouteHandler implements RouteHandlerInterface
{
    private $requiredName;

    private $request;
    
    public function __construct(Request $request){
        $this->request = $request;
    }
    
    public function match()
    {
        parent::match();
        
        if ($this->fillable['name'] === $this->requiredName) {
            $this->matched = Matched::create($this->fillable);
        }
    }

    public function getUrl(string $routeName, array $params = []) : string
    {
        $this->requiredName = $routeName;
    
        $segments = explode('.', $this->requiredName);
        
        Route::plug($segments[0]);
        
        if (is_null($this->matched)) {
            throw new RouteIsNotFoundForNameException($routeName);
        }
        
        return $this->buildUrl($params);
    }
    
    private function buildUrl(array $params) : string
    {
        foreach ($params as $placeholderSelector => $value) {
            
            $placeholder = ('{$' . $placeholderSelector . '}');

            if (!preg_match('(' . preg_quote($placeholder) . ')', $this->fillable['pattern'])) {
                throw new PlaceholderIsNotFoundForRoute($placeholderSelector, $this->fillable['pattern'], $this->requiredName);
            }
            
            $this->fillable['pattern'] = str_replace($placeholder, $value, $this->fillable['pattern']);
        }
        
        return $this->request->getProtocol() . '://' . $this->request->getHost() . '/' . $this->fillable['pattern'];
    }
}
