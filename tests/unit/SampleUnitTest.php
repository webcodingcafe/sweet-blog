<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversNothing]
final class SampleUnitTest extends TestCase
{
    #[TestWith([true])]
    public function testAlwaysEvaluatesToTrue(bool $condition): void
    {
        self::assertTrue($condition);
    }
}
