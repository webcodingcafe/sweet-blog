<?php

declare(strict_types=1);

use SweetBlog\Autoloader;
use SweetBlog\Core\Http\HttpKernel;

require __DIR__ . '/Autoloader.php';

new Autoloader(__DIR__)->register();

$response = new HttpKernel()->handle();
$response->send();
