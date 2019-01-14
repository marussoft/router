<?php

namespace Marussia\Components\Router\Exceptions;

class Error404Exception extends \Exception
{

    public function __construct($uri)
    {
        $message = 'Страница ' . $uri . ' не найдена.';
    
        parent::__construct($message);
    }

}
 
