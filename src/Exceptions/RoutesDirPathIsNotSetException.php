<?php

declare(strict_types=1);

namespace Marussia\Router\Exceptions;

class RoutesDirPathIsNotSetException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Routes directory path is not set');
    }
}
