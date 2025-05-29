<?php

declare(strict_types=1);

namespace Tests\Integration;

use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class SampleIntegrationTest extends IntegrationTestCase
{
    public function testMakeHttpRequest(): void
    {
        try {
            $response = self::$client->get('/');
        } catch (GuzzleException $e) {
            self::fail($e->getMessage());
        }

        self::assertSame(200, $response->getStatusCode());
        self::assertNotEmpty($response->getBody()->getContents());
    }
}
