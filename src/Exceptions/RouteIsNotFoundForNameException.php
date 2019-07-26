<?php

namespace Marussia\Router\Exceptions;

class RouteIsNotFoundForNameException extends \Exception
{
    public function __construct($routeName)
    {
        parent::__construct(static::MESSAGE);
    }
}
