<?php

/*
 * Copyright (c) 2024 Daniela Kleemann
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace Tests\Core;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;
use SweetBlog\Core\Request;

#[RunTestsInSeparateProcesses]
#[CoversClass(Request::class)]
final class RequestTest extends TestCase
{
    #[TestWith(['GET'])]
    #[TestWith(['POST'])]
    #[TestWith(['HEAD'])]
    public function testGetRequestMethod(string $method): void
    {
        $_SERVER['REQUEST_METHOD'] = $method;

        $request = new Request();

        self::assertSame($method, $request->method());
    }

    #[TestWith(['/'])]
    #[TestWith(['/foo/bar'])]
    #[TestWith(['/foo#bar'])]
    #[TestWith(['/foo?bar=biz'])]
    public function testGetRequestUri(string $uri): void
    {
        $_SERVER['REQUEST_URI'] = $uri;

        $request = new Request();

        self::assertSame($uri, $request->uri());
    }

    public function testRequestMethodNotOfTypeString(): void
    {
        $_SERVER['REQUEST_METHOD'] = 42;

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Request method must be a string.');

        $request = new Request();
        $request->method();
    }

    public function testRequestUriNotOfTypeString(): void
    {
        $_SERVER['REQUEST_URI'] = 42;

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Request URI must be a string.');

        $request = new Request();
        $request->uri();
    }

    public function testRequestMethodNotSet(): void
    {
        unset($_SERVER['REQUEST_METHOD']);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Request method not set.');

        $request = new Request();
        $request->method();
    }

    public function testRequestUriNotSet(): void
    {
        unset($_SERVER['REQUEST_URI']);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Request URI not set.');

        $request = new Request();
        $request->uri();
    }
}
