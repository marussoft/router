<?php

namespace Marussia\Router\Contracts;

interface RequestInterface
{
    public function getUri() : string;
    
    public function getMethod() : string;
    
    public function getHost() : string;
    
    public function getProtocol() : string;
} 
