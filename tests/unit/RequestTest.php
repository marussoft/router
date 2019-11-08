<?php

declare(strict_types=1);

namespace Marussia\Router\Test;

use PHPUnit\Framework\TestCase;
use Marussia\Router\Request;

class RequestTest extends TestCase
{
    public function testGetProtocol(): void
    {
        $this->assertEquals('https', self::request()->getProtocol());
    }

    public function testGetHost(): void
    {
        $this->assertEquals('host.ru', self::request()->getHost());
    }

    public function testGetMethod(): void
    {
        $this->assertEquals('GET', self::request()->getMethod());
    }

    public function testGetUriByDefault(): void
    {
        $this->assertEquals('/', self::request()->getUri());
    }

    public function testGetUri(): void
    {
        $this->assertEquals('news/list', self::request('/news/list?p=1')->getUri());
    }

    public function testIsMethod(): void
    {
        $this->assertTrue(self::request()->isMethod('GET'));
    }

    private static function request(string $uri = ''): Request
    {
        $uri = empty($uri) ? '/' : $uri;
        $method = 'get';
        $host = 'host.ru';
        $protocol = 'https';
        return new Request($uri, $method, $host, $protocol);
    }
}
