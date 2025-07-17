<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Http;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SweetBlog\Core\Http\Response;
use SweetBlog\Core\Http\ResponseBody;
use SweetBlog\Core\Http\ResponseHeaders;
use SweetBlog\Core\Http\StatusCode;

#[CoversClass(Response::class)]
final class ResponseTest extends TestCase
{
    #[Test]
    public function canBeInitializedWithDefaultValues(): void
    {
        $response = new Response();
        $response->send();

        self::assertSame(StatusCode::Ok->value, http_response_code());
        $this->expectOutputString('');
    }

    #[Test]
    public function canBeInitializedWithCustomValues(): void
    {
        $response = new Response(
            body: new ResponseBody('content not found'),
            headers: new ResponseHeaders(),
            statusCode: StatusCode::NotFound,
        );
        $response->send();

        self::assertSame(StatusCode::NotFound->value, http_response_code());
        $this->expectOutputString('content not found');
    }
}
