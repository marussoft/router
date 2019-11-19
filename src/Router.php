<?php

declare(strict_types=1);

namespace Marussia\Router;

use Marussia\DependencyInjection\Container;

class Router
{
    private $resolver;

    private $request;
    
    private $routeFilePlug;

    public function __construct(Resolver $resolver, UrlGenerator $urlGenerator, Mapper $mapper, Request $request, RouteFilePlug $routeFilePlug)
    {
        $this->resolver = $resolver;
        $this->request = $request;
        $this->routeFilePlug = $routeFilePlug;
        Route::setHandler($mapper);
        Url::setUrlGenerator($urlGenerator);
    }

    public static function create(string $uri, string $method, string $host, string $protocol = 'http') : self
    {
        $container = Container::create();
        $container->instance(Request::class, [$uri, $method, $host, $protocol]);
        return $container->instance(static::class);
    }

    public function setRoutesDirPath(string $dirPath) : self
    {
        $this->routeFilePlug->setRoutesDirPath($dirPath);
        return $this;
    }

    public function setRoutesAliases(array $aliases) : self
    {
        $this->routeFilePlug->setRoutesAliases($aliases);
        return $this;
    }
    
    public function setLanguages(array $languages) : self
    {
        $this->resolver->setLanguages($languages);
        return $this;
    }

    public function startRouting() : Result
    {
        return $this->resolver->resolve();
    }
}
