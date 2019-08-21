<?php

namespace Marussia\Router\Exceptions;

class HandlerIsNotSetException extends \Exception
{
    public function __construct(string $pattern)
    {
        parent::__construct('Handler is not set for pattern ' . $pattern);
    }
}
