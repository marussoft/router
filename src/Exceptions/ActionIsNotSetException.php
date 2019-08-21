<?php

namespace Marussia\Router\Exceptions;

class ActionIsNotSetException extends \Exception
{
    public function __construct(string $pattern)
    {
        parent::__construct('Action is not set for pattern ' . $pattern);
    }
} 
