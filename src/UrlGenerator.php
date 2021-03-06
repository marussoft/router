<?php

declare(strict_types=1);

namespace Marussia\Router;

use Marussia\Router\Contracts\RouteHandlerInterface;
use Marussia\Router\Exceptions\RouteIsNotFoundForNameException;
use Marussia\Router\Exceptions\PlaceholderIsNotFoundForRouteException;
use Marussia\Router\Exceptions\PlaceholdersParamsIsNotFoundException;

class UrlGenerator extends AbstractRouteHandler implements RouteHandlerInterface
{
    protected $requiredName;

    protected $route;

    protected $request;

    protected $routeFilePlug;

    public function __construct(RouteFilePlug $routeFilePlug, Request $request)
    {
        $this->routeFilePlug = $routeFilePlug;

        $this->request = $request;
    }

    public function match() : void
    {
        parent::match();

        if ($this->fillable['name'] === $this->requiredName) {
            $this->matched = MatchedRoute::create($this->fillable);
        }
    }

    public function getUrl(string $routeName, array $params = [], string $lang = '') : string
    {
        $this->fillable = [];
        $this->matched = null;

        $this->requiredName = $routeName;

        $segments = explode('.', $this->requiredName);

        $this->routeFilePlug->plug($segments[0]);

        if (is_null($this->matched)) {
            throw new RouteIsNotFoundForNameException($routeName);
        }

        return $this->buildUrl($params, $lang);
    }

    private function buildUrl(array $params, string $lang) : string
    {
        if (preg_match('(\$[a-z]+)', $this->fillable['pattern']) && empty($params)) {
            throw new PlaceholdersParamsIsNotFoundException($this->fillable['pattern']);
        }

        foreach ($params as $placeholderSelector => $value) {

            $placeholder = ('{$' . $placeholderSelector . '}');

            if (!preg_match('(' . preg_quote($placeholder) . ')', $this->fillable['pattern'])) {
                throw new PlaceholderIsNotFoundForRouteException($placeholderSelector, $this->fillable['pattern'], $this->requiredName);
            }

            $this->fillable['pattern'] = str_replace($placeholder, $value, $this->fillable['pattern']);
        }

        $uri = trim($this->fillable['pattern'], '/');

        if (!empty($lang)) {
            $uri = $lang . '/' . $uri;
        }

        return $this->request->getProtocol() . '://' . $this->request->getHost() . '/' . $uri;
    }
}
