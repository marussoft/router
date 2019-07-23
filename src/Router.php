<?php

declare(strict_types=1);

namespace Marussia\Router;

use Marussia\DependencyInjection\Container;

class Router
{
    private $resolver;
    
    private $mapper;
    
    private $routesDirPath = '';
    
    private $uri = '';
    
    private $method = '';
    
    private const ROUTE_FILE_NAME = 'default';

    public function __construct(Storage $storage, Resolver $resolver, Mapper $mapper)
    {
        $this->resolver = $resolver;
        $this->mapper = $mapper;
        RouteBuilder::setStorage($storage);
    }
    
    public static function create() : self
    {
        $container = Container::create();
        return $container->instance(static::class);
    }
    
    public function setRoutesDirPath(string $dirPath) : self
    {
        $this->routesDirPath = $dirPath;
        return $this;
    }
    
    public function setUri(string $uri) : self
    {
        $this->uri = $uri;
        return $this;
    }
    
    public function setMethod(string $method) : self
    {
        $this->method = strtolower($method);
        return $this;
    }
    
    public function setHost(string $host) : self
    {
        $this->host = $host;
        return $this;
    }
    
    public function startRouting() : Result
    {
        $this->prepareRoutes();
    
        $route = $this->mapper->getRoute($this->method, $this->uri);

        if ($route === null) {
            return Result::create(false);
        }
        
        return $this->resolver->resolve($route);
    }
    
    // Возвращает полный URL по имени роута // Допилить в последнюю очередь
    public function getUrl(string $routeName, array $params = []) :? string
    {
        // Часть перенести сюда из mapper (подключение файлов роутов)
        return $this->mapper->getUrl($routeName, $params);
    }
    
    private function prepareRoutes()
    {
        if (empty($this->uri)) {
            throw new \Exception('Uri is not seted');
        }
        
        if (empty($this->method)) {
            throw new \Exception('Method is not seted');
        }
        
        if (empty($this->routesDirPath)) {
            throw new \Exception('Routes directory path is not seted');
        }
        
        $segments = explode('/', $this->uri);
        
        $this->plugRoutes($segments[0]);
    }
    
    // Переделать на доменное исключение
    private function plugRoutes($routesFileName)
    {
//         try {
            require_once $this->routesDirPath . $routesFileName . '.php';
//         } catch (\Throwable $e) {
//             require_once $this->routesDirPath . self::ROUTE_FILE_NAME . '.php';
//         }
    }
}
