<?php

namespace Marussia\Router\Exceptions;

class ActionIsNotSetedException extends \Exception
{
    public function __construct(string $pattern)
    {
        parent::__construct('Action is not seted for pattern' . $pattern);
    }
} 
