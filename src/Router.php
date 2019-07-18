<?php

declare(strict_types=1);

namespace Marussia\Router;

use Marussia\DependencyInjection\Container;
use Marussia\Router\Contracts\StorageInterface;

class Router
{
    private $resolver;
    
    private $mapper;

    public function __construct(StorageInterface $storage, Resolver $resolver, Mapper $mapper)
    {
        $this->resolver = $resolver;
        $this->mapper = $mapper;
        RouteBuilder::setStorage($storage);
    }
    
    public statis function create() : self
    {
        $container = new Container();
        $container->setClassMap(require 'class_map.php');
        return $container->instance(static::class);
    }
    
    public function setStorage(StorageInterface $storage) : void
    {
        RouteBuilder::setStorage($storage);
        $this->mapper->setStorage($storage);
    }
}
