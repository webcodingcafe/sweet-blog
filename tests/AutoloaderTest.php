<?php

/*
 * Copyright (c) 2024 Daniela Kleemann
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\TestCase;
use SweetBlog\Autoloader;

#[RunTestsInSeparateProcesses]
#[CoversClass(Autoloader::class)]
final class AutoloaderTest extends TestCase
{
    public function testRegisterAutoloader(): void
    {
        $autoloader = new Autoloader(__NAMESPACE__, __DIR__);
        $autoloader->register();

        self::assertContains([$autoloader, 'loadClass'], spl_autoload_functions());
    }

    public function testLoadClass(): void
    {
        $className = Fixtures\FooBar::class;

        $autoloader = new Autoloader(__NAMESPACE__, __DIR__);
        $autoloader->loadClass($className);

        self::assertTrue(\class_exists($className, autoload: false));
    }

    public function testInvalidBaseDirectoryPath(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid base directory path.');

        (new Autoloader(__NAMESPACE__, '/non-existing/directory'));
    }
}
