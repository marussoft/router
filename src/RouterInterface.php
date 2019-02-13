<?php

namespace Marussia\Router;

interface RouterInterface
{
    public function setMethod(string $method) : void;
    
    // Запускаем роутинг
    public function run(string $uri) : void;
    
    // Возвращает полученные данные
    public function getMap() : array;
    
    // Путь к каталогу с маршрутами
    public function setRoutesPath(string $path) : void;

}
