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
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use SweetBlog\Core\Request;
use SweetBlog\Core\Router;
use SweetBlog\Core\Routes;
use SweetBlog\Exception\HttpNotFoundException;

#[RunTestsInSeparateProcesses]
#[CoversClass(Router::class)]
#[UsesClass(Request::class)]
#[UsesClass(Routes::class)]
final class RouterTest extends TestCase
{
    #[TestWith(['GET', '/', \SweetBlog\Controllers\HomeController::class])]
    public function testResolve(string $method, string $uri, string $expectedController): void
    {
        $_SERVER['REQUEST_METHOD'] = $method;
        $_SERVER['REQUEST_URI'] = $uri;

        $router = new Router(new Request(), new Routes());

        try {
            $controller = $router->resolve();
        } catch (HttpNotFoundException $e) {
            self::fail($e->getMessage());
        }

        self::assertSame($expectedController, $controller);
    }

    #[TestWith(['POST', '/'])]
    #[TestWith(['GET', '/non-existing-uri'])]
    public function testNoMatchingRouteFound(string $method, string $uri): void
    {
        $_SERVER['REQUEST_METHOD'] = $method;
        $_SERVER['REQUEST_URI'] = $uri;

        $this->expectException(\SweetBlog\Exception\HttpNotFoundException::class);

        (new Router(new Request(), new Routes()))->resolve();
    }
}
