<?php

namespace Marussia\Router\Exceptions;

class RouteIsNotFoundForNameException extends \Exception
{
    public function __construct($routeName)
    {
        parent::__construct('Route is not found for route name ' . $routeName);
    }
}
