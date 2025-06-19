<?php

declare(strict_types=1);

namespace Tests\Integration\Core\Http;

use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\Attributes\CoversClass;
use SweetBlog\Core\Http\HttpKernel;
use Tests\BaseIntegrationTestCase;

#[CoversClass(HttpKernel::class)]
final class HttpKernelTest extends BaseIntegrationTestCase
{
    public function testSendRequest(): void
    {
        try {
            $response = self::$client->get('/');
        } catch (GuzzleException $e) {
            $this->fail($e->getMessage());
        }

        $httpStatusCode = $response->getStatusCode();
        $content = $response->getBody()->getContents();

        $this->assertSame(200, $httpStatusCode);
        $this->assertSame('Hello, world!', $content);
    }
}
