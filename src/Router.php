<?php

declare(strict_types=1);

namespace Marussia\Router;

use Marussia\DependencyInjection\Container;

class Router
{
    private $resolver;
    
    private $mapper;

    public function __construct(Resolver $resolver, Mapper $mapper, UrlGenerator $urlGenerator)
    {
        $this->resolver = $resolver;
        $this->mapper = $mapper;
        Url::setUrlGenerator($urlGenerator);
    }
    
    public static function create() : self
    {
        $container = Container::create();
        return $container->instance(static::class);
    }
    
    public function setRoutesDirPath(string $dirPath) : self
    {
        Route::routesDirPath($dirPath);
        return $this;
    }
    
    public function startRouting() : Result
    {
        return $this->resolver->resolve($route);
    }

}
