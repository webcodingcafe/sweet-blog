<?php

declare(strict_types=1);

namespace Tests\Unit;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\TestCase;
use SweetBlog\Autoloader;

#[RunTestsInSeparateProcesses]
#[CoversClass(Autoloader::class)]
final class AutoloaderTest extends TestCase
{
    public function testNonExistentBaseDirectory(): void
    {
        $baseDirectory = '/non/existent/directory';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Base directory "%s" does not exist.', $baseDirectory));

        new Autoloader($baseDirectory);
    }

    public function testRegister(): void
    {
        $autoloader = new Autoloader(__DIR__);

        assert(!in_array([$autoloader, 'loadClass'], spl_autoload_functions(), true));

        $autoloader->register();

        self::assertContains([$autoloader, 'loadClass'], spl_autoload_functions());
        self::assertTrue(spl_autoload_unregister([$autoloader, 'loadClass']));
    }

    public function testLoadClass(): void
    {
        $baseDirectory = dirname(__DIR__) . '/Fixtures/Placeholder/Autoloader';
        $clasName = 'SweetBlog\Foo';

        assert(!class_exists($clasName, false));

        $autoloader = new Autoloader($baseDirectory);
        $autoloader->loadClass($clasName);

        self::assertTrue(class_exists($clasName, false));
    }

    public function testLoadClassNotInSweetBlogNamespace(): void
    {
        $baseDirectory = dirname(__DIR__) . '/Fixtures/Placeholder/Autoloader';
        $clasName = 'Bar';

        assert(!class_exists($clasName, false));

        $autoloader = new Autoloader($baseDirectory);
        $autoloader->loadClass($clasName);

        self::assertFalse(class_exists($clasName, false));
    }

    #[DoesNotPerformAssertions]
    public function testLoadNonExistentClass(): void
    {
        $baseDirectory = dirname(__DIR__) . '/Fixtures/Placeholder/Autoloader';
        $className = 'SweetBlog\NonExistentClass';

        assert(!class_exists($className, false));

        $autoloader = new Autoloader($baseDirectory);
        $autoloader->loadClass($className);
    }
}
