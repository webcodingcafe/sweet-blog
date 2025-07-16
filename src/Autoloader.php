<?php

declare(strict_types=1);

namespace SweetBlog;

use InvalidArgumentException;

/**
 * Sweet Blog autoloader.
 *
 * The autoloader follows the PSR-4 specification for automatic loading of classes.
 *
 * @see https://www.php-fig.org/psr/psr-4/
 */
final readonly class Autoloader
{
    private const string NAMESPACE_SEPARATOR = '\\';
    private const string PREFIX = __NAMESPACE__ . self::NAMESPACE_SEPARATOR;
    private const string FILE_EXTENSION = '.php';

    /**
     * @param string $baseDirectoryPath Absolute path of the base directory: /web/project/src
     */
    public function __construct(
        private string $baseDirectoryPath,
    ) {
        $this->validateBaseDirectoryPath();
    }

    /**
     * Attempts to load the class being used from the base directory path.
     */
    public function loadClass(string $fullyQualifiedClassName): void
    {
        if (!$this->isInAppNamespace($fullyQualifiedClassName)) {
            return;
        }

        $relativeClassName = $this->removePrefixFromFullyQualifiedClassName($fullyQualifiedClassName);

        $filePath = $this->buildClassFilePath($relativeClassName);

        $this->requireClassFile($filePath);
    }

    /**
     * Adds the autoloader to PHP#s SPL autoload queue.
     */
    public function register(): void
    {
        spl_autoload_register([$this, 'loadClass']);
    }

    private function validateBaseDirectoryPath(): void
    {
        if (!is_dir($this->baseDirectoryPath)) {
            throw new InvalidArgumentException(sprintf(
                'The provided base directory path does not exist or is not a directory: %s',
                $this->baseDirectoryPath,
            ));
        }
    }

    private function isInAppNamespace(string $fullyQualifiedClassName): bool
    {
        return str_starts_with($fullyQualifiedClassName, self::PREFIX);
    }

    private function removePrefixFromFullyQualifiedClassName(string $fullyQualifiedClassName): string
    {
        return substr($fullyQualifiedClassName, strlen(self::PREFIX));
    }

    private function buildClassFilePath(string $relativeClassName): string
    {
        return (
            $this->baseDirectoryPath .
            DIRECTORY_SEPARATOR .
            str_replace(self::NAMESPACE_SEPARATOR, DIRECTORY_SEPARATOR, $relativeClassName) .
            self::FILE_EXTENSION
        );
    }

    private function requireClassFile(string $filePath): void
    {
        if (!file_exists($filePath)) {
            return;
        }

        require $filePath;
    }
}
