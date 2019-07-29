<?php

namespace Marussia\Router\Exceptions;

class PlaceholderIsNotFoundForRouteException extends \Exception
{
    public function __construct($placeholderSelector, $pattern, $requiredName)
    {
        parent::__construct('Placeholder ' . $placeholderSelector . ' is not found for ' . $requiredName . ' in ' . $pattern);
    }
}
