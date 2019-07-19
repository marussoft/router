<?php

namespace Marussia\Router\Contracts;

use Marussia\Router\Route;

interface StorageInterface
{
    public function has(string $routeName) : bool;
    
    public function getRoutes(string $method) : array;
    
    public function get(string $routeName) : Route;
}
 
