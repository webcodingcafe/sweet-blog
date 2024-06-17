<?php

/*
 * Copyright (c) 2024 Daniela Kleemann
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace Tests\Core;

use PHPUnit\Framework\Attributes\CoversClass;
use SweetBlog\Core\Routes;
use PHPUnit\Framework\TestCase;

#[CoversClass(Routes::class)]
final class RoutesTest extends TestCase
{
    public function testRoutes(): void
    {
        $routes = new Routes();

        $expected = [
            ['GET', '/', \SweetBlog\Controllers\HomeController::class],
        ];

        $actual = \iterator_to_array($routes());

        self::assertSame($expected, $actual);
    }
}
