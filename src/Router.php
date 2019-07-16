<?php

declare(strict_types=1);

namespace Marussia\Router;

use Marussia\Router\Exceptions\RouteNotFoundException;

class Router
{
    private $uri = '';
    
    private $segments = [];
    
    private $route = [];
    
    private $param = [];
    
    private $path = '';
    
    private $method = '';
    
    public function setMethod(string $method) : void
    {
        // Передаем метод запроса
        Route::setMethod($method);
    }
    
    // Запускаем роутинг
    public function run(string $uri) : void
    {
        // Если не пусто то запускаем обработку, иначе отработает по умолчанию
        if (!empty($uri)) {
            $this->uri = $uri;
            $this->prepareRequest();
        }
    }
    
    public function getMap() : array
    {
        return $this->segments;
    }
    
    public function setRoutesPath(string $path) : void
    {
        // Путь к каталогу с маршрутами
        $this->path = $path;
    }
    
    // Подготавливает запрос
    private function prepareRequest() : void
    {
        // Разбиваем запрос на сегменты
        $this->param = explode('/', $this->uri);

        // Передаем uri для последующей обработки
        Route::setUri($this->uri);

        // Подготавливаем маршруты
        $this->prepareRoute();
    }

    // Подготавливает маршруты для контроллеров
    private function prepareRoute() : void
    {
        $routes_file = $this->path . $this->param[0] . '.php';

        // Проверяем наличие файла маршрутов для запроса
        if (file_exists($routes_file)) {
            require_once($routes_file);
        }

        // Если маршруты не получены то подключаем роуты по-умолчанию
        if (empty(Route::controller())) {
            require_once $this->path . 'default.php';
        }

        // Обрабатываем запрос для контроллера
        $this->makeRoute();
    }

    // Собирает сегменты запроса
    private function makeRoute() : void
    {
        if (empty(Route::controller())) {
            throw new RouteNotFoundException($this->uri);
        }

        $this->route = Route::routes();
        $this->segments['controller'] = Route::controller() === '?' ? ucfirst($this->param[0]) : Route::controller();
        $this->segments['action'] = Route::action() === '?' ? ucfirst($this->param[1]) : Route::action();

        if (Route::alias()) {
            $this->segments['alias'] = $this->param[0];
        }

        $this->segments['slug'] = $this->param[0];
        
        unset($this->param[0]);

        if (Route::nesting()) {
            $this->assignNesting();
        }

        $this->assignSegments();
    }

    // Присваивает сегменты для вложенностей
    private function assignNesting() : void
    {
        $property = [];

        foreach ($this->param as $key => $segment) {
            if (preg_match('(^[a-z0-9\-]+$)', $segment, $property)) {
                $this->segments['nesting'] = $property[0];
                unset($this->param[$key]);
                continue;
            }
            break;
        }
    }

    // Присваивает значения сегментов запроса
    private function assignSegments() : void
    {
        $routes = $this->generator($this->route);

        $property = [];

        foreach ($this->param as $segment) {

            $value = $routes->current();
            $name = $routes->key();

            // Если роут соответствует то формируем поле
            if (preg_match("($value)", $segment, $property)) {
                $this->segments[$name] = $property[0];
                $routes->next();
                unset($this->route[$name]);
            }
        }

        if (!empty($this->route)) {
            $this->segments = array_merge($this->segments, $this->route);
        }
    }
    
    // Создает генератор
    private function generator(array $array)
    {
        foreach ($array as $key => $value) {
            yield $key => $value;
        }
    }
}
