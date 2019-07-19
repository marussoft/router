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
    
    public static function create() : self
    {
        $container = Container::create();
        $container->setClassMap(require 'class_map.php');
        return $container->instance(static::class);
    }
    
    public function setStorage(StorageInterface $storage) : self
    {
        RouteBuilder::setStorage($storage);
        $this->mapper->setStorage($storage);
        return $this;
    }
    
    public function setUrl(string $uri) : self
    {
        $this->mapper->setUri($uri);
        return $this;
    }
    
    public function setMethod(string $method) : self
    {
        $this->mapper->setMethod($method);
        return $this;
    }
    
    public function startRouting() : Result
    {
        return $this->resolver->startRouting();
    }
    
    public function getUrl(string $routeName, array $params = [])
    {
        return $this->mapper->getUrl($routeName, $params);
    }
}
