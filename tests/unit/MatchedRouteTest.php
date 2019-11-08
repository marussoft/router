<?php

declare(strict_types=1);

namespace Marussia\Router\Test;

use PHPUnit\Framework\TestCase;
use Marussia\Router\MatchedRoute;

class MatchedRouteTest extends TestCase
{
    public function testName(): void
    {
        $this->assertEquals('news.show', self::matchedRoute()->name);
    }

    public function testPattern(): void
    {
        $this->assertEquals('news/show/{$slug}', self::matchedRoute()->pattern);
    }

    public function testHandler(): void
    {
        $this->assertEquals('News', self::matchedRoute()->handler);
    }

    public function testAction(): void
    {
        $this->assertEquals('Show', self::matchedRoute()->action);
    }

    public function testMethod(): void
    {
        $this->assertEquals('get', self::matchedRoute()->method);
    }

    public function testWhere(): void
    {
        $this->assertEquals(['slug' => '([a-z0-9\-]+)'], self::matchedRoute()->where);
    }

    private static function matchedRoute(): MatchedRoute
    {
        return MatchedRoute::create([
            'name' => 'news.show',
            'pattern' => 'news/show/{$slug}',
            'handler' => 'News',
            'action' => 'Show',
            'method' => 'get',
            'where' => ['slug' => '([a-z0-9\-]+)'],
        ]);
    }
}
