<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Http;

use Generator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SweetBlog\Core\Http\HttpStatusCode;

#[CoversClass(HttpStatusCode::class)]
final class HttpStatusCodeTest extends TestCase
{
    /**
     * @return \Generator<array{0: HttpStatusCode, 1: int}>
     */
    public static function statusCodeProvider(): Generator
    {
        yield '200 OK' => [HttpStatusCode::Ok, 200];
        yield '404 Not Found' => [HttpStatusCode::NotFound, 404];
    }

    #[DataProvider('statusCodeProvider')]
    public function testEnumCases(HttpStatusCode $statusCode, int $expected): void
    {
        $this->assertSame($expected, $statusCode->value);
    }
}
