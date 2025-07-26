<?php

declare(strict_types=1);

namespace Tests\Unit;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use SweetBlog\Autoloader;

#[RunTestsInSeparateProcesses]
#[CoversClass(Autoloader::class)]
final class AutoloaderTest extends TestCase
{
    private static string $fixturesDirectory;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$fixturesDirectory = dirname(__DIR__) . '/Fixtures';

        if (!is_dir(self::$fixturesDirectory)) {
            throw new RuntimeException('Missing Fixtures directory.');
        }
    }

    #[TestWith(['/non-existent/directory/path'])]
    public function testThrowsExceptionIfBaseDirectoryDoesNotExist(string $baseDirectoryPath): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Autoloader('SweetBlog', $baseDirectoryPath);
    }

    public function testCanBeRegistered(): void
    {
        $autoloader = new Autoloader('SweetBlog', __DIR__);
        $autoloader->register();

        self::assertContains([$autoloader, 'loadClass'], spl_autoload_functions());
    }

    #[TestWith(['Tests\Fixtures\AutoloaderTest\ClassToLoad'])]
    public function testCanLoadClassFronBaseDirectory(string $className): void
    {
        $autoloader = new Autoloader('Tests\Fixtures', self::$fixturesDirectory);
        $autoloader->loadClass($className);

        self::assertTrue(class_exists(class: $className, autoload: false));
    }

    #[TestWith(['Tests\Fixtures\AutoloaderTest\ClassToLoad'])]
    public function testIgnoresClassesNotInAppNamespace(string $className): void
    {
        $autoloader = new Autoloader('Tests\FooBar', self::$fixturesDirectory);
        $autoloader->loadClass($className);

        self::assertFalse(class_exists(class: $className, autoload: false));
    }

    #[DoesNotPerformAssertions]
    #[TestWith(['Tests\Fixtures\AutoloaderTest\NonExistentClass'])]
    public function testDoesNotRaiseErrorsIfClassDoesNotExist(string $className): void
    {
        $autoloader = new Autoloader('Tests\Fixtures', self::$fixturesDirectory);
        $autoloader->loadClass($className);
    }
}
