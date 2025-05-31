<?php

declare(strict_types=1);

namespace SweetBlog;

use InvalidArgumentException;

/**
 * Sweet Blog Autoloader.
 *
 * The autoloader follows the PSR-4 specification for autoloading classes.
 *
 * @see https://www.php-fig.org/psr/psr-4/
 */
final readonly class Autoloader
{
    /**
     * The namespace prefix with a trailing namespace separator.
     */
    private const string PREFIX = __NAMESPACE__ . '\\';

    /**
     * Autoloader constructor.
     *
     * @param string $baseDirectory The base directory path.
     */
    public function __construct(
        private string $baseDirectory,
    ) {
        if (!is_dir($this->baseDirectory)) {
            throw new InvalidArgumentException(sprintf('Base directory "%s" does not exist.', $this->baseDirectory));
        }
    }

    /**
     * Attempts to load the class file for a given class name.
     *
     * @param string $className The fully qualified class name.
     *
     * @return void
     */
    public function loadClass(string $className): void
    {
        // Only handle classes in the SweetBlog namespace
        if (!str_starts_with($className, self::PREFIX)) {
            return;
        }

        // Remove the namespace prefix
        $relativeClass = substr($className, strlen(self::PREFIX));

        $relativeFilePath = str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) . '.php';
        $filePath = $this->baseDirectory . DIRECTORY_SEPARATOR . $relativeFilePath;

        if (is_file($filePath)) {
            require $filePath;
        }
    }

    /**
     * Prepends the autoloader to PHP's SPL autoloader queue.
     *
     * @return void
     */
    public function register(): void
    {
        spl_autoload_register([$this, 'loadClass'], true, true);
    }
}
