<?php

namespace SweetBlog;

use InvalidArgumentException;

/**
 * Sweet Blog Autoloader.
 *
 * This class handles automatic loading of class files in the SweetBlog application.
 * It eliminates the need for manual 'require' or 'include' statements for each class file.
 * When PHP encounters an undefined class, this autoloader attempts to find and load
 * the appropriate file based on the class namespace and name.
 *
 * For example, when using the class \SweetBlog\Actions\Home, the autoloader will look for
 * a file at {baseDirectory}/Actions/Home.php and load it automatically if found.
 *
 * The autoloader follows the PSR-4 specification for automatic loading of classes, which
 * maps namespace prefixes to directory structures in a standardized way.
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
     * Constructor method for initializing the class with a base directory and registering the autoloader.
     *
     * @param string $baseDirectory The base directory path. It must exist and be readable.
     *
     * @return void
     *
     * @throws InvalidArgumentException If the provided base directory does not exist or is not readable.
     */
    public function __construct(
        private string $baseDirectory,
    ) {
        if (!is_dir($this->baseDirectory) || !is_readable($this->baseDirectory)) {
            throw new InvalidArgumentException(
                sprintf("The base directory '%s' does not exist or is not readable.", $this->baseDirectory),
            );
        }

        // Register this class as an autoloader, enabling automatic class loading throughout the application
        spl_autoload_register($this);
    }

    /**
     * Attempts to load the class being used.
     *
     * @param string $className The fully qualified class name of the class to load.
     *
     * @return void
     */
    public function __invoke(string $className): void
    {
        // Skip classes outside our namespace - we only handle our own classes
        if (!str_starts_with($className, self::PREFIX)) {
            return;
        }

        // Remove the namespace prefix
        $relativeClass = substr($className, strlen(self::PREFIX));

        // Convert the relative classname to the relative file path
        $relativeFilePath = str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) . '.php';

        $classFilePath = $this->baseDirectory . DIRECTORY_SEPARATOR . $relativeFilePath;

        if (!is_file($classFilePath) || !is_readable($classFilePath)) {
            return;
        }

        require $classFilePath;
    }
}
