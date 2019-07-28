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
    
    public static function get(string $routeName, array $params = []) : string
    {
        if (is_null(static::$uriGenerator)) {
            throw new \Exception('Router is not initialized');
        }
    
        Route::setHandler(static::$uriGenerator);
    
        return static::$uriGenerator->getUrl($routeName, $params);
    }
}
