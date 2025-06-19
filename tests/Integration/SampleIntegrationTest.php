<?php

declare(strict_types=1);

namespace Tests\Integration;

use PHPUnit\Framework\Attributes\CoversNothing;
use Tests\BaseIntegrationTestCase;

#[CoversNothing]
final class SampleIntegrationTest extends BaseIntegrationTestCase
{
    public function testHttpRequest(): void
    {
        $response = self::$client->get('/', ['http_errors' => false]);

        $this->assertNotEmpty($response->getHeaders());
    }
}
