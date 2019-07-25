<?php

declare(strict_types=1);

namespace Marussia\Router;

use Marussia\Router\Contracts\RequestInterface;

class Request implements RequestInterface
{
    private $data;

    public function __construct()
    {
        $this->data = $_SERVER;
        
        $uri = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL);
        
        if (!empty($this->data['REQUEST_URI'])) {
            $this->uri = preg_replace('(\?.*$)', '', trim($uri, '/'));
        }
    }


    public function getUri()
    {
        return $this->uri;
    }
    
    public function getMethod()
    {
        return $this->data['REQUEST_METHOD'];
    }
    
    public function isMethod(string $method)
    {
        return $this->data['REQUEST_METHOD'] === strtoupper($method);
    }
    
    public function getHost()
    {
    
    }
    
    public function getProtocol()
    {
    
    }
}
