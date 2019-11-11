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

    private $regExps = [
        'STRING' => '([a-z0-9\-]+)',
        'INTEGER' => '([0-9]+)',
        'ARRAY' => '([a-z0-9]+)/(([a-z0-9\-]+/)+|([a-z0-9\-_]+)+)($)', // Возможно ошибка
    ];

    private const ATTRIBUTE_TYPE_INTEGER = 'INTEGER';

    private const ATTRIBUTE_TYPE_ARRAY = 'ARRAY';

    private const ATTRIBUTE_DELIMITER = '/';

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
            $where = $this->prepareWhere($matched->where, $matched->pattern);
            $attributesTypesMap = $this->prepareTypes($matched->where);
            $rawAttributes = $this->assignAttributes($where, $matched->pattern);
            $result->attributes = $this->typeСonversion($rawAttributes, $attributesTypesMap);
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
        $rawAttributes = [];

        $uri = $this->request->getUri();

        // Вынести в метод
        while (key($where) !== null) {
            $pattern = str_replace('{$' . key($where) . '}', ' ', $pattern);
            next($where);
        }

        $segments = explode(' ', trim($pattern, ' '));

        foreach ($where as $key => $value) {

            $needless = array_shift($segments);

            $uri = substr($uri, strlen($needless));

            $delimiter = substr($value, 0, 1) === '(' ? ')' : substr($value, 0, 1);

            // Вынести в метод
            if (isset($segments[0]) === false) {
                $withNeedless = substr($value, 0, -1) . $delimiter;
            } else {
                $withNeedless = substr($value, 0, -1) . preg_quote($segments[0]) . $delimiter;
            }

            preg_match($withNeedless, $uri, $matched);

            if (empty($segments)) {
                $rawAttributes[$key] = $matched[0];
            } else {
                $rawAttributes[$key] = substr($matched[0], 0, -(strlen(current($segments))));
            }

            $uri = substr($uri, strlen($rawAttributes[$key]));
        }

        return $rawAttributes;
    }

    private function prepareWhere(array $where, string $pattern) : array
    {
        preg_match_all('(\{\$[a-zA-Z]+\})', $pattern, $matched, PREG_SET_ORDER);

        foreach ($matched as $value) {

            $placeHolder = substr($value[0], 2, -1);

            if (array_key_exists($where[$placeHolder], $this->regExps)) {
                $sortedWhere[$placeHolder] = $this->regExps[$placeHolder];
                continue;
            }

            $sortedWhere[$placeHolder] = $where[$placeHolder];
        }

        return $sortedWhere;
    }

    private function prepareTypes(array $where) : array
    {
        $attributesTypesMap = [];

        foreach ($where as $placeHolder => $value) {
            if (array_key_exists($placeHolder, $this->regExps) === false) {
                continue;
            }

            if ($this->regExps[$placeHolder] === self::ATTRIBUTE_TYPE_INTEGER) {
                $attributesTypesMap[$placeHolder] = self::ATTRIBUTE_TYPE_INTEGER;
                continue;
            }

            if ($this->regExps[$placeHolder] === self::ATTRIBUTE_TYPE_ARRAY) {
                $attributesTypesMap[$placeHolder] = self::ATTRIBUTE_TYPE_ARRAY;
            }
        }

        return $attributesTypesMap;
    }

    private function typeСonversion(array $rawAttributes, array $attributesTypesMap) : array
    {
        $attributes = [];

        if (empty($attributesTypesMap)) {
            return $rawAttributes;
        }

        foreach ($rawAttributes as $placeHolder => $value) {

            if (array_key_exists($placeHolder, $attributesTypesMap) === false) {
                continue;
            }

            if ($attributesTypesMap[$placeHolder] === self::ATTRIBUTE_TYPE_INTEGER) {
                $attributes[$placeHolder] = intval($value);
                continue;
            }

            if ($attributesTypesMap[$placeHolder] === self::ATTRIBUTE_TYPE_ARRAY) {
                $attributes[$placeHolder] = explode(self::ATTRIBUTE_DELIMITER, $value);
                continue;
            }
        }

        return $attributes;
    }
}
