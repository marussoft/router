<?php

declare(strict_types=1);

namespace Marussia\Router;

class Result implements \ArrayAccess
{
    protected $status = false;

    public $handler = '';
    
    public $action = '';
    
    public $attributes = [];
    
    public function status() : bool
    {
        return $this->status;
    }
}
