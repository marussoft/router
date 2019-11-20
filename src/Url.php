<?php

declare(strict_types=1);

namespace Marussia\Router;

use Marussia\Router\Exceptions\RouterIsNotInitializedException;

class Url
{
    private static $uriGenerator = null;

    public static function setUrlGenerator(UrlGenerator $uriGenerator)
    {
        static::$uriGenerator = $uriGenerator;
    }

    public static function get(string $routeName, array $params = [], string $lang = '') : string
    {
        if (is_null(static::$uriGenerator)) {
            throw new RouterIsNotInitializedException();
        }

        Route::setHandler(static::$uriGenerator);

        return static::$uriGenerator->getUrl($routeName, $params, $lang);
    }
}

