<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\TestCase;

#[CoversNothing]
class SampleUnitTest extends TestCase
{
    /**
     * @var bool true
     */
    private bool $condition = true;

    public function testShouldAlwaysPass(): void
    {
        $this->assertTrue($this->condition);
    }
}
