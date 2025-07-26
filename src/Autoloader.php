<?php

declare(strict_types=1);

namespace SweetBlog;

use InvalidArgumentException;

/**
 * Sweet Blog autoloader.
 *
 * The autoloader follows the PSR-4 specification for class autoloading.
 *
 * @see https://www.php-fig.org/psr/psr-4/
 */
final readonly class Autoloader
{
    /**
     * Constructor.
     *
     * @param string $namespacePrefix Namespace prefix
     * @param string $baseDirectory Absolute path of the base directory
     */
    public function __construct(
        private string $namespacePrefix,
        private string $baseDirectory,
    ) {
        if (!is_dir($this->baseDirectory)) {
            throw new InvalidArgumentException(sprintf(
                'The provided base directory "%s" does not exist or is not a directory.',
                $this->baseDirectory,
            ));
        }
    }

    /**
     * Attempts to load the class from the provided base directory.
     *
     * @param string $fullyQualifiedClassName The class to load
     *
     * @return void
     */
    public function loadClass(string $fullyQualifiedClassName): void
    {
        if (!str_starts_with($fullyQualifiedClassName, $this->namespacePrefix)) {
            return;
        }

        $relativeClassName = substr($fullyQualifiedClassName, strlen($this->namespacePrefix) + 1);

        $filePath =
            $this->baseDirectory
            . DIRECTORY_SEPARATOR
            . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClassName)
            . '.php';

        if (file_exists($filePath)) {
            require $filePath;
        }
    }

    /**
     * Adds the autoloader to PHP's SPL autoload queue.
     *
     * @return void
     */
    public function register(): void
    {
        spl_autoload_register([$this, 'loadClass']);
    }
}
