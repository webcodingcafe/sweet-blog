<?php

/*
 * Copyright (c) 2024 Daniela Kleemann
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace Tests\Core;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;
use SweetBlog\Core\View;
use SweetBlog\Exception\MissingViewFileException;

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

    #[TestWith(['file42'])]
    #[TestWith(['foobar.php'])]
    #[TestWith(['foo/bar'])]
    public function testInvalidFileName(string $viewFileName): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid view file name.');

        $view = new View(\dirname(__DIR__) . '/Fixtures/views');

        try {
            $view->render($viewFileName);
        } catch (MissingViewFileException $e) {
            self::fail($e->getMessage());
        }
    }

    public function testMissingViewFile(): void
    {
        $viewFileName = 'non-existing';

        $this->expectException(MissingViewFileException::class);
        $this->expectExceptionMessage("Missing view file: {$viewFileName}");

        $view = new View(\dirname(__DIR__) . '/Fixtures/views');
        $view->render($viewFileName);
    }
}
