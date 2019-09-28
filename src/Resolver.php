<?php

declare(strict_types=1);

namespace Marussia\Router;

use Marussia\Router\Contracts\RequestInterface;

class Resolver
{
    private $mapper;

    private $request;

    private $segments = [];

    private $matched;

    private $languages =[];

    private $currentLanguage;

    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
        Route::setHandler($mapper);
    }

    public function resolve() : Result
    {
        $this->uri = $this->request->getUri();

        $this->segments = explode('/', $this->uri);

        if (!empty($this->languages)) {
            $this->prepareLanguage();
        }

        $this->prepareRoutes();

        return $this->buildResult();
    }

    public function setRequest(RequestInterface $request) : void
    {
        $this->request = $request;
        $this->mapper->setRequest($request);
    }

    public function setLanguages(array $languages = []) : self
    {
        $this->languages = $languages;
        return $this;
    }

    private function buildResult() : Result
    {
        if (!$this->mapper->isMatched()) {
            return Result::create(false);
        }

        $matched = $this->mapper->getMatched();

        $result = Result::create(true);
        $result->handler = $matched->handler;
        $result->action = $matched->action;
        $result->language = $this->currentLanguage;
        if (!empty($matched->where)) {
            $result->attributes = $this->assignAttributes($matched->where, $matched->pattern);
        }
        return $result;
    }

    private function prepareRoutes() : void
    {
        if (empty($this->uri) or $this->uri === '/' or empty($this->segments)) {
            Route::plug();
            return;
        }

        Route::plug($this->segments[0]);
    }

    private function prepareLanguage()
    {
        if (array_search($this->segments[0], $this->languages, true) !== false) {
            $this->currentLanguage = array_shift($this->segments);
        }

        $uri = trim(str_replace($this->languages, '', $this->uri), '/');

        if (empty($uri)) {
            $uri = '/';
        }

        $this->request->setUri($uri);
    }

    private function assignAttributes(array $where, string $pattern) : array
    {
        $attributes = [];

        $uri = $this->request->getUri();

        while (key($where) !== null) {
            $pattern = str_replace('{$' . key($where) . '}', ' ', $pattern);
            next($where);
        }

        $segments = explode(' ', $pattern);

        while (key($segments) !== null) {
            $uri = str_replace(current($segments), ' ', $uri);
            next($segments);
        }

        $needs = explode(' ', trim($uri));

        foreach ($where as $key => $regExp) {

            $attributes[$key] = is_numeric(current($needs)) ? intval(current($needs)) : current($needs);

            next($needs);
        }

        return $attributes;
    }

}
