<?php

declare(strict_types=1);

namespace Marussia\Router;

class RouteFilePlug
{
    private $routesDirPath;

    public function setRoutesDirPath(string $routesDirPath) : void
    {
        $this->routesDirPath = $routesDirPath;
    }

    public function plug(string $routesFileName = '') : void
    {
        if (empty($this->routesDirPath)) {
            throw new \Exception('Routes directory path is not seted');
        }
        require $this->routesDirPath . $routesFileName . '.php';
    }
}
