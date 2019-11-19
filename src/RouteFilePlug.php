<?php

declare(strict_types=1);

namespace Marussia\Router;

use Marussia\Router\Exceptions\RoutesDirPathIsNotSetException;
use Marussia\Router\Exceptions\RouteFileAliasIsNotStringException;

class RouteFilePlug
{
    private $routesDirPath;
    
    private $aliases = [];
    
    private const ROUTE_DEFAULT_FILE_NAME = 'default';

    public function setRoutesDirPath(string $routesDirPath) : void
    {
        $this->routesDirPath = $routesDirPath;
    }

    public function setRoutesAliases(array $aliases) : void
    {
        $this->aliases = $aliases;
    }

    
    public function plug(string $routesFileName) : void
    {
        if (empty($this->routesDirPath)) {
            throw new RoutesDirPathIsNotSetException('Routes directory path is not set');
        }
        
        $routesFileName = $this->prepareFileAlias($routesFileName);
        
        if (is_file($this->routesDirPath . $routesFileName . '.php') === false) {
            $this->plugDefault();
            return;
        }
        
        require $this->routesDirPath . $routesFileName . '.php';
    }
    
    public function plugDefault() : void
    {
        if (empty($this->routesDirPath)) {
            throw new RoutesDirPathIsNotSetException('Routes directory path is not set');
        }
        require $this->routesDirPath . self::ROUTE_DEFAULT_FILE_NAME . '.php';
    }

    private function prepareFileAlias(string $routesFileName) : string
    {
        if (isset($this->aliases[$routesFileName]) === false) {
            return $routesFileName;
        }
        
        if (is_string($this->aliases[$routesFileName]) === false) {
            throw new RouteFileAliasIsNotStringException($routesFileName, get_type($this->aliases[$routesFileName]));
        }
        return $this->aliases[$routesFileName];
    }
}
