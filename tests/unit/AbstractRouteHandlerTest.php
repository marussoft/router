<?php

declare(strict_types=1);

namespace Marussia\Router\Test;

use Mockery;
use PHPUnit\Framework\TestCase;
use Marussia\Router\Request;
use Marussia\Router\AbstractRouteHandler;
use Marussia\Router\MatchedRoute;
use Marussia\Router\Exceptions\HandlerIsNotSetException;
use Marussia\Router\Exceptions\ActionIsNotSetException;
use Marussia\Router\Exceptions\PlaceholdersForPatternNotFoundException;

class AbstractRouteHandlerTest extends TestCase
{
    public function testGetIntegerPlaceholderRegExp() : void
    {
        $routeHandler = self::routeHandler();
        $this->assertEquals('([0-9]+)', $routeHandler->getPlaceholderRegExp('integer'));
    }
    
    public function testGetStringPlaceholderRegExp() : void
    {
        $routeHandler = self::routeHandler();
        $this->assertEquals('([a-z0-9\-]+)', $routeHandler->getPlaceholderRegExp('string'));
    }
    
    public function testGetArrayPlaceholderRegExp() : void
    {
        $routeHandler = self::routeHandler();
        $this->assertEquals('([a-z0-9]+)/(([a-z0-9\-]+/)+|([a-z0-9\-_]+)+)($)', $routeHandler->getPlaceholderRegExp('array'));
    }
    
    public function testHasIntegerPlaceholderType() : void
    {
        $routeHandler = self::routeHandler();
        $this->assertTrue($routeHandler->hasPlaceholderType('integer'));
    }

    public function testHasStringPlaceholderType() : void
    {
        $routeHandler = self::routeHandler();
        $this->assertTrue($routeHandler->hasPlaceholderType('string'));
    }
    
    public function testHasArrayPlaceholderType() : void
    {
        $routeHandler = self::routeHandler();
        $this->assertTrue($routeHandler->hasPlaceholderType('array'));
    }
    
    public function testRoute(): void
    {
        $routeHandler = self::routeHandler();
        $routeHandler->route('get', 'news/show/{$slug}.html');

        $fillable = $routeHandler->fillable();

        $this->assertEquals('get', $fillable['method']);
        $this->assertEquals('news/show/{$slug}.html', $fillable['pattern']);
    }

    public function testWhere(): void
    {
        $routeHandler = self::routeHandler();
        $routeHandler->where(['slug' => '([a-z0-9\-]+)']);

        $fillable = $routeHandler->fillable();

        $this->assertEquals(['slug' => '([a-z0-9\-]+)'], $fillable['where']);
    }

    public function testName(): void
    {
        $routeHandler = self::routeHandler();
        $routeHandler->name('news.show');

        $fillable = $routeHandler->fillable();

        $this->assertEquals('news.show', $fillable['name']);
    }

    public function testHandler(): void
    {
        $routeHandler = self::routeHandler();
        $routeHandler->handler('News');

        $fillable = $routeHandler->fillable();

        $this->assertEquals('News', $fillable['handler']);
    }

    public function testAction(): void
    {
        $routeHandler = self::routeHandler();
        $routeHandler->action('Show');

        $fillable = $routeHandler->fillable();

        $this->assertEquals('Show', $fillable['action']);
    }

    public function testMatch(): void
    {
        $routeHandler = self::routeHandler();
        $routeHandler
            ->route('get', 'news/show/${id}-{$slug}.html')
            ->handler('News')
            ->action('Show')
            ->where(['id' => '([0-9]+)', 'slug' => '([a-z0-9\-]+)'])
            ->match();

        $this->assertTrue(true);
    }

    public function testMatchWhenPlaceholderHasCamelCaseCharacters(): void
    {
        $routeHandler = self::routeHandler();
        $routeHandler
            ->route('get', 'news/show/${id}-{$slugString}.html')
            ->handler('News')
            ->action('Show')
            ->where(['id' => '([0-9]+)', 'slugString' => '([a-z0-9\-]+)'])
            ->match();

        $this->assertTrue(true);
    }

    public function testMatchWhenHandlerIsNotSet(): void
    {
        $this->expectException(HandlerIsNotSetException::class);

        $routeHandler = self::routeHandler();
        $routeHandler
            ->route('get', 'news/show/{$slug}.html')
            ->match();
    }

    public function testMatchWhenActionIsNotSet(): void
    {
        $this->expectException(ActionIsNotSetException::class);

        $routeHandler = self::routeHandler();
        $routeHandler
            ->route('get', 'news/show/{$slug}.html')
            ->handler('News')
            ->match();
    }

    public function testMatchWhenWhereIsSetAndPatternDoesNotContainPlaceholders(): void
    {
        $this->expectException(PlaceholdersForPatternNotFoundException::class);

        $routeHandler = self::routeHandler();
        $routeHandler
            ->route('get', 'news/show/{slug}.html')
            ->handler('News')
            ->action('Show')
            ->where(['slug' => '([a-z0-9\-]+)'])
            ->match();
    }

    public function testIsMatched(): void
    {
        $routeHandler = self::routeHandler();
        $routeHandler->setMatched(self::matchedRoute());

        $this->assertTrue($routeHandler->isMatched());
    }

    public function testIsMatchedWhenIsNotMatched(): void
    {
        $routeHandler = self::routeHandler();

        $this->assertFalse($routeHandler->isMatched());
    }

    private static function routeHandler(): RouteHandler
    {
        $request = Mockery::mock(Request::class);
        return new RouteHandler($request);
    }

    private static function matchedRoute(): MatchedRoute
    {
        return MatchedRoute::create([
            'name' => 'news.show',
            'pattern' => 'news/show/{$slug}.html',
            'handler' => 'News',
            'action' => 'Show',
            'method' => 'get',
            'where' => ['slug' => '([a-z0-9\-]+)'],
        ]);
    }
}

class RouteHandler extends AbstractRouteHandler
{
    public function fillable(): array
    {
        return $this->fillable;
    }

    public function setMatched(MatchedRoute $matchedRoute): void
    {
        $this->matched = $matchedRoute;
    }
}
