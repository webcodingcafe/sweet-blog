<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Http;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SweetBlog\Core\Http\HttpResponseBody;

#[CoversClass(HttpResponseBody::class)]
final class HttpResponseBodyTest extends TestCase
{
    public function testDefaultEmptyString(): void
    {
        $httpResponseBody = new HttpResponseBody();

        $this->assertSame('', $httpResponseBody->content);
    }

    public function testSetHttpResponseBodyContent(): void
    {
        $content = 'test';

        $httpResponseBody = new HttpResponseBody($content);

        $this->assertSame($content, $httpResponseBody->content);
    }
}
