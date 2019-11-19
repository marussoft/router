<?php

declare(strict_types=1);

namespace Marussia\Router\Exceptions;

class RouterIsNotInitializedException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Router is not initialized');
    }
}
