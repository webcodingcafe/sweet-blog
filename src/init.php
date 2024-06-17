<?php

/*
 * Copyright (c) 2024 Daniela Kleemann
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

use SweetBlog\Core\Router;

require __DIR__ . '/Autoloader.php';

(new \SweetBlog\Autoloader('SweetBlog', __DIR__))->register();

$router = new Router(
    new \SweetBlog\Core\Request(),
    new \SweetBlog\Core\Routes(),
);

try {
    $controllerClass = $router->resolve();

    if (!class_exists($controllerClass)) {
        throw new Exception("Class {$controllerClass} does not exist.");
    }

    if (!method_exists($controllerClass, '__invoke')) {
        throw new Exception("Class {$controllerClass} does not have a __invoke method.");
    }

    (new $controllerClass())();
} catch (\SweetBlog\Exception\HttpNotFoundException $e) {
    http_response_code(404);
    error_log($e->getMessage());
    echo '404 Not Found';
} catch (Exception $e) {
    http_response_code(500);
    error_log($e->getMessage());
    echo 'Something went wrong.';
}
