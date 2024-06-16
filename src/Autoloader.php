<?php

/*
 * Copyright (c) 2024 Daniela Kleemann
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace SweetBlog;

/**
 * Application specific autoloader.
 */
final readonly class Autoloader
{
    /**
     * @param string $appNamespace Application namespace prefix
     * @param string $baseDirectory Absolute source directory path
     */
    public function __construct(
        private string $appNamespace,
        private string $baseDirectory,
    ) {
        if (!\is_dir($this->baseDirectory)) {
            throw new \InvalidArgumentException('Invalid base directory path.');
        }
    }

    /**
     * Adds the autoloader to the SPL autoload queue.
     *
     * @return void
     */
    public function register(): void
    {
        \spl_autoload_register([$this, 'loadClass']);
    }

    /**
     * Loads a class being used automatically.
     *
     * @param string $className Fully-qualified class name of the class to load
     *
     * @return void
     */
    public function loadClass(string $className): void
    {
        $relativeClass = \substr($className, \strlen($this->appNamespace));
        $relativePath = \str_replace('\\', \DIRECTORY_SEPARATOR, $relativeClass);
        $classFile = $this->baseDirectory . $relativePath . '.php';

        if (\file_exists($classFile)) {
            require $classFile;
        }
    }
}
