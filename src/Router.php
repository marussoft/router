<?php

declare(strict_types=1);

namespace Marussia\Router;

use Marussia\DependencyInjection\Container;

class Router
{
    private $builder;
    
    private $resolver;
    
    private $mapper;

    public function __construct(RouteBuilder $builder, Resolver $resolver, Mapper $mapper)
    {
        $this->builder = $builder;
        $this->resolver = $resolver;
        $this->mapper = $mapper;
    }

    public statis function create() : self
    {
        $container = new Container();
        $container->setClassMap(require 'class_map.php');
        return $container->instance(static::class);
    }
    
    public function route() : RouteBuilder
    {
        return $this->builder;
    }
}
