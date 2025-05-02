<?php

namespace Tests;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversNothing]
final class SampleTest extends TestCase
{
    #[TestWith([true])]
    public function testAlwaysEvaluatesToTrue(bool $condition): void
    {
        $this->assertTrue($condition);
    }
}
