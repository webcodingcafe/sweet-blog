<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Http;

use Generator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SweetBlog\Core\Http\HttpResponse;
use SweetBlog\Core\Http\HttpResponseBody;
use SweetBlog\Core\Http\HttpStatusCode;

#[CoversClass(HttpResponse::class)]
final class HttpResponseTest extends TestCase
{
    /**
     * @return \Generator<array{0: string, 1: HttpStatusCode}>
     */
    public static function HttpResponseProvider(): Generator
    {
        yield 'ok' => ['ok', HttpStatusCode::Ok];
        yield 'not found' => ['not found', HttpStatusCode::NotFound];
    }

    public function testDefaults(): void
    {
        $httpResponse = new HttpResponse();

        $this->assertSame('', $httpResponse->httpResponseBody->content);
        $this->assertSame(HttpStatusCode::Ok, $httpResponse->httpStatusCode);
    }

    #[DataProvider('HttpResponseProvider')]
    public function testSend(string $content, HttpStatusCode $httpStatusCode): void
    {
        $httpResponseBody = new HttpResponseBody($content);

        $httpResponse = new HttpResponse($httpResponseBody, $httpStatusCode);
        $httpResponse->send();

        $this->assertSame($httpStatusCode->value, http_response_code());
        $this->expectOutputString($httpResponseBody->content);
    }
}
