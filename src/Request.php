<?php

declare(strict_types=1);

namespace Marussia\Router;

class Request
{
    private $method;

    private $uri = '/';

    private $host;

    private $protocol;

    public function __construct(string $uri, string $method, string $host, string $protocol)
    {
        $this->method = strtoupper($method);

        $this->host = $host;

        $this->protocol = $protocol;

        if (!empty($uri) && $uri !== '/') {
            $this->uri = preg_replace('(\?.*$)', '', trim($uri, '/'));
        }
    }

    public function getUri() : string
    {
        return $this->uri;
    }

    public function replaceUri(string $uri)
    {
        $this->uri = $uri;
    }

    public function getMethod() : string
    {
        return $this->method;
    }

    public function isMethod(string $method) : bool
    {
        return $this->method === strtoupper($method);
    }

    public function getHost() : string
    {
        return $this->host;
    }

    public function getProtocol() : string
    {
        return $this->protocol;
    }
}
