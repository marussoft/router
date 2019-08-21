<?php

namespace Marussia\Router\Contracts;

interface RouteHandlerInterface
{
    public function route(string $method, string $pattern);
    
    public function where(array $where);
    
    public function name(string $name);
    
    public function handler(string $handler);
    
    public function action(string $action);
    
    public function match();
}
