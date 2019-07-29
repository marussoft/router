<?php

namespace Marussia\Router\Exceptions;

class HandlerIsNotSetedException extends \Exception
{
    public function __construct(string $pattern)
    {
        parent::__construct('Handler is not seted for pattern' . $pattern);
    }
}
