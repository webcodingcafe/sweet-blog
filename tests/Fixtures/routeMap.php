<?php

declare(strict_types=1);

use SweetBlog\App\Controllers\HomeController;
use SweetBlog\Core\Http\HttpMethod;

return [
    [HttpMethod::GET, '/', [HomeController::class, 'index']],
    [HttpMethod::HEAD, '/', [HomeController::class, 'index']],
];
