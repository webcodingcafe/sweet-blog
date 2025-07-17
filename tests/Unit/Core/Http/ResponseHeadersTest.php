<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Http;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SweetBlog\Core\Http\ResponseHeaders;

#[CoversClass(ResponseHeaders::class)]
final class ResponseHeadersTest extends TestCase
{
    #[Test]
    public function canAddNewHeaderField(): void
    {
        $responseHeaders = new ResponseHeaders();
        $responseHeaders->add('X-Test', 'Test');

        self::assertSame('Test', $responseHeaders->headerFields['X-Test']);
    }

    #[Test]
    public function addOverwritesExistingHeaderFieldWithSameFieldName(): void
    {
        $responseHeaders = new ResponseHeaders();
        $responseHeaders->add('X-Test', 'Test-A');
        $responseHeaders->add('X-Test', 'Test-B');

        self::assertSame('Test-B', $responseHeaders->headerFields['X-Test']);
    }
}
