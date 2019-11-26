<?php

declare(strict_types=1);

namespace Marussia\Router;

use Marussia\Router\Contracts\RouteHandlerInterface;

class Mapper extends AbstractRouteHandler implements RouteHandlerInterface
{
    protected $matched = null;

    public function match() : void
    {
        parent::match();

        if (!is_null($this->matched)) {
            return;
        }

        if (!$this->request->isMethod(strtoupper($this->fillable['method']))) {
            return;
        }

        $pattern = $this->fillable['pattern'];

        // @todo добавить проверку на существование плейсхолдера с выбросом исключения
        if (!empty($this->fillable['where'])) {
            foreach ($this->fillable['where'] as $key => $condition) {
                if ($this->hasPlaceholderType($condition)) {
                    $pattern = str_replace('{$' . $key . '}', $this->getPlaceholderRegExp($condition), $pattern);
                    continue;
                }
                $pattern = str_replace('{$' . $key . '}', $condition, $pattern);
            }
        }

        if (!preg_match("(^$pattern$)", $this->request->getUri())) {
            return;
        }

        $this->matched = MatchedRoute::create($this->fillable);
    }

    public function getMatched() : MatchedRoute
    {
        return $this->matched;
    }
}
