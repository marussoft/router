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
    
    public function __construct(bool $status)
    {
        $this->status = $status;
    }
    
    public static function create(bool $status) : self
    {
        return new static($status);
    }
}
