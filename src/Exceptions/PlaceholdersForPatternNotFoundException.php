<?php

namespace Marussia\Router\Exceptions;

class PlaceholdersForPatternNotFound extends \Exception
{
    public function __construct(string $pattern)
    {
        parent::__construct('Placeholders for ' . $pattern . ' not found');
    }
} 
