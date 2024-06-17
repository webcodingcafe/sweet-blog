<?php

/*
 * Copyright (c) 2024 Daniela Kleemann
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace Tests\Controllers;

use PHPUnit\Framework\Attributes\CoversClass;
use SweetBlog\Controllers\HomeController;
use PHPUnit\Framework\TestCase;

#[CoversClass(HomeController::class)]
final class HomeControllerTest extends TestCase
{
    public function testHelloWorld(): void
    {
        $this->expectOutputString('Hello, world!');

        (new HomeController())();
    }
}
