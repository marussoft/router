<?php

declare(strict_types=1);

namespace Marussia\Router;

class UrlGenerator
{
    private $resolver;

    public function __construct(Resolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function getUrl(string $routeName, array $params = []) : string
    {

    }
    
    private function buildUrl(Matched $matched, array $params) : string
    {
    
    }
}
