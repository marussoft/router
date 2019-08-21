<?php

namespace Marussia\Router\Exceptions;

class PlaceholdersParamsIsNotFoundException extends \Exception
{
    public function __construct(string $pattern)
    {
        parent::__construct('Params for placeholders in pattern ' . $pattern . 'is not received');
    }
} 
