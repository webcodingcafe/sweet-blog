<?php

declare(strict_types=1);

namespace Tests\Unit;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;
use SweetBlog\Autoloader;

#[CoversClass(Autoloader::class)]
#[RunTestsInSeparateProcesses]
final class AutoloaderTest extends TestCase
{
    private static string $fixturesDirectory;

    #[Override]
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$fixturesDirectory = dirname(__DIR__) . '/Fixtures';
    }

    #[Test]
    #[TestWith(['/non/existent/directory'])]
    public function throwsExceptionWhenBaseDirectoryDoesNotExist(string $nonExistentDirectory): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf(
            'The provided base directory path does not exist or is not a directory: %s',
            $nonExistentDirectory,
        ));

        new Autoloader($nonExistentDirectory);
    }

    #[Test]
    public function canBeRegistered(): void
    {
        $autoloader = new Autoloader(self::$fixturesDirectory);

        $autoloader->register();

        self::assertContains([$autoloader, 'loadClass'], spl_autoload_functions());
    }

    #[Test]
    #[TestWith(['SweetBlog\AutoloaderTest\ClassInAppNamespace'])]
    public function canLoadClass(string $fullyQualifiedClassName): void
    {
        $autoloader = new Autoloader(self::$fixturesDirectory);
        $autoloader->loadClass($fullyQualifiedClassName);

        self::assertTrue(class_exists(
            class: $fullyQualifiedClassName,
            autoload: false,
        ));
    }

    #[Test]
    #[TestWith(['Fixtures\AutoloaderTest\ClassNotInAppNamespace'])]
    public function ignoresClassNotInApNamespace(string $fullyQualifiedClassName): void
    {
        $autoloader = new Autoloader(self::$fixturesDirectory);
        $autoloader->loadClass($fullyQualifiedClassName);

        self::assertFalse(class_exists(
            class: $fullyQualifiedClassName,
            autoload: false,
        ));
    }

    #[Test]
    #[TestWith(['SweetBlog\AutoloaderTest\NonExistentClass'])]
    #[DoesNotPerformAssertions]
    public function doesNotRaiseErrorWhenClassFileDoesNotExist(string $fullyQualifiedClassName): void
    {
        $autoloader = new Autoloader(self::$fixturesDirectory);
        $autoloader->loadClass($fullyQualifiedClassName);
    }
}
