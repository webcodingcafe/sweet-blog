<?php

declare(strict_types=1);

namespace Tests\Integration;

use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\Attributes\CoversNothing;
use Tests\IntegrationTestCase;

#[CoversNothing]
final class SampleIntegrationTest extends IntegrationTestCase
{
    public function testSendRequest(): void
    {
        try {
            $response = self::$client->get('/');
        } catch (GuzzleException $e) {
            self::fail(sprintf('Failed to send a response: %s', $e->getMessage()));
        }

        self::assertSame(200, $response->getStatusCode());
    }
}
