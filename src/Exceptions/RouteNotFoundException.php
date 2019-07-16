<?php

namespace Marussia\Router\Exceptions;

class RouteNotFoundException extends \Exception
{

    private const MESSAGE = 'Route for ' . $uri . ' not found.';

    public function __construct($uri)
    {
        parent::__construct(static::MESSAGE);
    }
}
