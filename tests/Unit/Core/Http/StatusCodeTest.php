<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Http;

use Generator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SweetBlog\Core\Http\StatusCode;

#[CoversClass(StatusCode::class)]
final class StatusCodeTest extends TestCase
{
    /**
     * @return Generator<array{0: StatusCode, 1: int}>
     */
    public static function enumCaseProvider(): Generator
    {
        yield [StatusCode::Ok, 200];
        yield [StatusCode::NotFound, 404];
    }

    #[Test]
    #[DataProvider('enumCaseProvider')]
    public function hasEnumCaseWithExpectedValue(StatusCode $statusCode, int $expectedValue): void
    {
        self::assertSame($expectedValue, $statusCode->value);
    }
}
