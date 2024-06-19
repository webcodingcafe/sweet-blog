<?php

/*
 * Copyright (c) 2024 Daniela Kleemann
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace Tests\Core;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SweetBlog\Core\View;

#[CoversClass(View::class)]
final class ViewTest extends TestCase
{
    public function testLoadViewFile(): void
    {
        $expected = <<<HTML
            <!doctype html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Test</title>
            </head>
            <body>
                <p>Hello, world!</p>
            </body>
            </html>

            HTML;

        $this->expectOutputString($expected);

        $view = new View(\dirname(__DIR__) . '/Fixtures/views');

        $view->render('hello');
    }

    public function testInvalidViewDirectoryPath(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid views directory path.');

        (new View('/non-existing/directory'));
    }
}
