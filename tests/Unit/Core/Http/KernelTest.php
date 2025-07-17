<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Http;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SweetBlog\Core\Http\Kernel;
use SweetBlog\Core\Http\StatusCode;

#[CoversClass(Kernel::class)]
final class KernelTest extends TestCase
{
    #[Test]
    public function canHandleRequestAndSendResponse(): void
    {
        $kernel = new Kernel();
        $response = $kernel->handle();
        $response->send();

        self::assertSame(StatusCode::Ok->value, http_response_code());
        $this->expectOutputString('');
    }
}
