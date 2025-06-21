<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Http;

use Generator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SweetBlog\Core\Http\HttpMethod;

#[CoversClass(HttpMethod::class)]
final class HttpMethodTest extends TestCase
{
    /**
     * @return \Generator<array{0: HttpMethod, 1: string}>
     */
    public static function httpMethodCaseProvider(): Generator
    {
        yield 'GET' => [HttpMethod::GET, 'GET'];
        yield 'HEAD' => [HttpMethod::HEAD, 'HEAD'];
        yield 'POST' => [HttpMethod::POST, 'POST'];
    }

    #[DataProvider('httpMethodCaseProvider')]
    public function testEnumCases(HttpMethod $httpMethod, string $expectedMethod): void
    {
        $this->assertSame($expectedMethod, $httpMethod->value);
    }
}
