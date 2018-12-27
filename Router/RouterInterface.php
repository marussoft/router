<?php

namespace Marussia\Components\Router;

interface RouterInterface
{
    public function __construct(string $controller, string $action, string $path)
    
    // Запускаем роутинг
    public function run($uri) : void

    // Возвращает контроллер
    public function getController() : string

    // Возвращает экшн
    public function getAction() : string

    // Возвращает алиас
    public function getAlias() : string

}
