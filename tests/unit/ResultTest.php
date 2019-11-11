<?php

declare(strict_types=1);

namespace Marussia\Router\Test;

use PHPUnit\Framework\TestCase;
use Marussia\Router\Result;

class ResultTest extends TestCase
{
    public function testStatus(): void
    {
        $this->assertTrue(self::result()->status);
    }

    public function testAction(): void
    {
        $this->assertEquals('', self::result()->action);
    }

    public function testAttributes(): void
    {
        $this->assertEquals([], self::result()->attributes);
    }

    public function testLanguage(): void
    {
        $this->assertEquals('', self::result()->language);
    }

    private static function result(bool $status = true): Result
    {
        return Result::create($status);
    }
}
