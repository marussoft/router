<?php

declare(strict_types=1);

namespace Marussia\Router;

class Routefacade
{
    private $storage;
    
    private $factory;

    public function __construct(Storage $storage, RouteFactory $factory)
    {
        $this->storage = $storage;
        $this->factory = $factory;
    }

    public static function get()
    {
        $route = Factory::create('get');
        static::$storage->register($route);
        return $route;
    }
    
    public static function post()
    {
        $route = Factory::create('post');
        static::$storage->register($route);
        return $route;
    }
    
    public static function put()
    {
        $route = Factory::create('put');
        static::$storage->register($route);
        return $route;
    }
    
    public static function patch()
    {
        $route = Factory::create('patch');
        static::$storage->register($route);
        return $route;
    }
    
    public static function delete()
    {
        $route = Factory::create('delete');
        static::$storage->register($route);
        return $route;
    }
}
