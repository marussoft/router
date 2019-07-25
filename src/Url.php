<?php

declare(strict_types=1);

namespace Marussia\Router;

class Url
{
    private static $uriGenerator = null;
    
    public static function setUrlGenerator(UrlGenerator $uriGenerator)
    {
        static::$uriGenerator = $uriGenerator;
    }
    
    public static function getUrl(string $routeName, array $params)
    {
        if (is_null(static::$uriGenerator)) {
            throw new \Exception('Router is not initialized');
        }
    
        static::$uriGenerator->getUrl($routeName, $params);
    }
}
