<?php

namespace Tests;

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
    /**
     * The base directory path used in the test case.
     */
    private const string BASE_DIRECTORY = __DIR__ . '/Fixtures/SweetBlog';

    /**
     * Tests the initialization and registration of the autoloader.
     *
     * @return void
     */
    public function testRegisterTheAutoloader(): void
    {
        $autoloader = new Autoloader(self::BASE_DIRECTORY);

        $this->assertContains($autoloader, spl_autoload_functions());
        $this->assertTrue(spl_autoload_unregister($autoloader));
    }

    /**
     * Tests the behavior of the autoloader when initialized with a non-existent base directory.
     *
     * @return void
     */
    public function testNonExistentBaseDirectory(): void
    {
        $baseDirectory = '/non-existent';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The base directory '$baseDirectory' does not exist or is not readable.");

        new Autoloader($baseDirectory);
    }

    /**
     * Tests the autoloader's ability to load an existing class.
     *
     * @return void
     */
    public function testLoadExistingClass(): void
    {
        $className = 'SweetBlog\FooBar';

        $this->assertFalse(class_exists($className, false));

        $autoloader = new Autoloader(self::BASE_DIRECTORY);
        $autoloader($className);

        $this->assertTrue(class_exists($className, false));
    }

    /**
     * Tests that the NonSweetBlog class does not exist after attempting to load it with the autoloader.
     *
     * @return void
     */
    public function testLoadNonSweetBlogClass(): void
    {
        $className = 'FooBar\NonSweetBlog';

        $autoloader = new Autoloader(self::BASE_DIRECTORY);
        $autoloader($className);

        $this->assertFalse(class_exists($className, false));
    }

    /**
     * Tests the loading of a non-existent class to ensure no errors or exceptions are triggered.
     *
     * @return void
     */
    #[DoesNotPerformAssertions]
    public function testLoadNonExistentClass(): void
    {
        $className = 'SweetBlog\NonExistent';

        $autoloader = new Autoloader(self::BASE_DIRECTORY);
        $autoloader($className);
    }
}
