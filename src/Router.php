<?php

declare(strict_types=1);

namespace Marussia\Router;

use Marussia\DependencyInjection\Container;
use Marussia\Router\Contracts\RequestInterface;

class Router
{
    private $resolver;
    
    private $mapper;

    public function __construct(Resolver $resolver, UrlGenerator $urlGenerator, Mapper $mapper)
    {
        $this->resolver = $resolver;
        $this->mapper = $mapper;
        $this->urlGenerator = $urlGenerator;
        Url::setUrlGenerator($urlGenerator);
    }
    
    public static function create(string $uri, string $method, string $host, string $protocol = 'http') : self
    {
        $container = Container::create();
        $request = $container->instance(Request::class, [$uri, $method, $host, $protocol]);
        return $container->instance(static::class)->setRequest($request);
    }
    
    public function setRoutesDirPath(string $dirPath) : self
    {
        Route::setRoutesDirPath($dirPath);
        return $this;
    }
    
    public function setRequest(RequestInterface $request) : self
    {
        $this->resolver->setRequest($request);
        $this->urlGenerator->setRequest($request);
        return $this;
    }
    
    public function setLanguages(array $languages = []) : self
    {
        $this->resolver->setLanguages($languages);
        return $this;
    }
    
    public function startRouting() : Result
    {
        return $this->resolver->resolve();
    }

}
