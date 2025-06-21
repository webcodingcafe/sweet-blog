<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Http;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use SweetBlog\Core\Http\HttpRequest;

#[CoversClass(HttpRequest::class)]
final class HttpRequestTest extends TestCase
{
    public function testGetRequestInformation(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/test';

        $request = new HttpRequest();

        $this->assertSame('GET', $request->method);
        $this->assertSame('/test', $request->uri);
    }

    public function testRequestMethodNotSet(): void
    {
        $_SERVER['REQUEST_URI'] = '/';

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('REQUEST_METHOD not set');

        new HttpRequest();
    }

    public function testRequestUriNotSet(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('REQUEST_URI not set');

        new HttpRequest();
    }

    public function testRequestMethodHasUnexpectedType(): void
    {
        $_SERVER['REQUEST_METHOD'] = 42;
        $_SERVER['REQUEST_URI'] = '/';

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('REQUEST_METHOD must be of type string');

        new HttpRequest();
    }

    public function testRequestUriHasUnexpectedType(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = 42;

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('REQUEST_URI must be of type string');

        new HttpRequest();
    }

    #[TestWith(['DELETE'])]
    #[TestWith(['INVALID'])]
    #[TestWith(['get'])]
    #[TestWith(['PoSt'])]
    public function testRequestMethodNotSupported(string $method): void
    {
        $_SERVER['REQUEST_METHOD'] = $method;
        $_SERVER['REQUEST_URI'] = '/';

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Request method not supported: ' . $method);

        new HttpRequest();
    }

    #[Override]
    protected function tearDown(): void
    {
        unset($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

        parent::tearDown();
    }
}
