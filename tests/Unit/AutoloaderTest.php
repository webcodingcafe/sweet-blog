<?php

declare(strict_types=1);

namespace Tests\Unit;

use InvalidArgumentException;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\TestCase;
use SweetBlog\Autoloader;

#[CoversClass(Autoloader::class)]
class AutoloaderTest extends TestCase
{
    private static string $fixtureDirectory;

    #[Override]
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$fixtureDirectory = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Fixtures';
    }

    public function testMissingRootDirectory(): void
    {
        $rootDirectory = '/non/existent/directory';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Missing autoload root directory: {$rootDirectory}");

        new Autoloader($rootDirectory);
    }

    public function testRegisterAutoloader(): void
    {
        $autoloader = new Autoloader(__DIR__);
        $autoloader->register();

        $needle = [$autoloader, 'loadClass'];
        $haystack = spl_autoload_functions();

        $this->assertContains($needle, $haystack);
    }

    public function testLoadNonSweetBlogClass(): void
    {
        $className = 'Tests\Fixtures\AutoloaderTest\NotInSweetBlogNamespace';

        $autoloader = new Autoloader(self::$fixtureDirectory);
        $autoloader->loadClass($className);

        $condition = class_exists($className, autoload: false);

        $this->assertFalse($condition);
    }

    public function testLoadSweetBlogClass(): void
    {
        $className = 'SweetBlog\AutoloaderTest\InSweetBlogNamespace';

        $autoloader = new Autoloader(self::$fixtureDirectory);
        $autoloader->loadClass($className);

        $condition = class_exists($className, autoload: false);

        $this->assertTrue($condition);
    }

    #[DoesNotPerformAssertions]
    public function testLoadNonExistentClass(): void
    {
        // No exception or error of any kind should bubble up

        $className = 'Tests\Fixtures\AutoloaderTest\NonExistent';

        $autoloader = new Autoloader(self::$fixtureDirectory);
        $autoloader->loadClass($className);
    }
}
