<?php

/*
 * Copyright (c) 2024 Daniela Kleemann
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace Tests\Controllers;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use SweetBlog\Controllers\HomeController;
use PHPUnit\Framework\TestCase;
use SweetBlog\Core\View;

#[UsesClass(View::class)]
#[CoversClass(HomeController::class)]
final class HomeControllerTest extends TestCase
{
    public function testHelloWorld(): void
    {
        $view = new View(\dirname(__DIR__, 2) . '/src/views');

        $html = <<<HTML
            <!doctype html>
            <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <link rel="stylesheet" href="assets/css/style.css" >
                    <title>Document</title>
                </head>
                <body>
                    <p>Hello, world!</p>
                </body>
            </html>

            HTML;

        $this->expectOutputString($html);

        (new HomeController($view))();
    }
}
