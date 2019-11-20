<?php

declare(strict_types=1);

namespace Marussia\Router;

class Result
{
    public $status = false;

    public $handler = '';
    
    public $action = '';
    
    public $attributes = [];
    
    public $language = '';
}
