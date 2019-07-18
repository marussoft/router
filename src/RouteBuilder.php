<?php

declare(strict_types=1);

namespace Marussia\Router;

class RouteBuilder
{
    private $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }
    
    public function method(string $method)
    {
    
    }
}
