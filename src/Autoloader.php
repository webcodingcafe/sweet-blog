<?php

declare(strict_types=1);

namespace SweetBlog;

use InvalidArgumentException;

/**
 * Sweet Blog autoloader.
 *
 * The autoloader follows the PSR-4 specification.
 *
 * @see https://www.php-fig.org/psr/psr-4/
 */
final readonly class Autoloader
{
    /**
     * The namespace prefix.
     */
    private const string PREFIX = __NAMESPACE__ . '\\';

    /**
     * Creates an instance of the autoloader with the specified root directory.
     *
     * @param string $rootDirectory Root directory path
     */
    public function __construct(
        private string $rootDirectory,
    ) {
        if (!is_dir($this->rootDirectory)) {
            throw new InvalidArgumentException("Missing autoload root directory: {$this->rootDirectory}");
        }
    }

    /**
     * Attempts to load the specified class.
     *
     * @param string $className Fully qualified class name of the class to load
     *
     * @return void
     */
    public function loadClass(string $className): void
    {
        // Don't handle classes that are not in the SweetBlog namespace
        if (!str_starts_with($className, self::PREFIX)) {
            return;
        }

        // Remove the namespace prefix from the fully qualified class name
        $relativeClassName = substr($className, strlen(self::PREFIX));

        // Build the absolute path to the class file
        $relativeClassPath = str_replace('\\', DIRECTORY_SEPARATOR, $relativeClassName);
        $classFile = $this->rootDirectory . DIRECTORY_SEPARATOR . $relativeClassPath . '.php';

        if (file_exists($classFile)) {
            require $classFile;
        }
    }

    /**
     * Prepends the autoloader to the SPL autoload queue.
     *
     * @return void
     */
    public function register(): void
    {
        spl_autoload_register(callback: [$this, 'loadClass'], prepend: true);
    }
}
