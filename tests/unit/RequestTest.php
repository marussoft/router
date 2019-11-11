<?php

declare(strict_types=1);

namespace Marussia\Router\Test;

use Marussia\Router\Request;
use PHPUnit\Framework\TestCase;

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

    private static function request($uri = ''): Request
    {
        $uri = empty($uri) ? '/' : $uri;
        $method = 'get';
        $host = 'host.ru';
        $protocol = 'https';
        return new Request($uri, $method, $host, $protocol);
    }
}
