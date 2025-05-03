<?php

declare(strict_types=1);

require __DIR__ . '/Autoloader.php';

// The autoloader registers itself via spl_autoload_register() during instantiation
try {
    new \SweetBlog\Autoloader(__DIR__);
} catch (\InvalidArgumentException $exception) {
    error_log(sprintf("Failed to initialize autoloader: %s", $exception->getMessage()));
    exit(1);
}
