<?php

declare(strict_types=1);

require __DIR__ . '/Autoloader.php';
new \SweetBlog\Autoloader(__DIR__)->register();

$response = new \SweetBlog\Core\Http\Kernel()->handle();
$response->send();
