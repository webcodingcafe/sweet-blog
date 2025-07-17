<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Http;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SweetBlog\Core\Http\ResponseBody;

#[CoversClass(ResponseBody::class)]
final class ResponseBodyTest extends TestCase
{
    #[Test]
    public function hasDefaultValueEmptyString(): void
    {
        $responseBody = new ResponseBody();
        self::assertSame('', $responseBody->content);
    }

    #[Test]
    public function canBeInitializedWithContent(): void
    {
        $responseBody = new ResponseBody('content');
        self::assertSame('content', $responseBody->content);
    }
}
