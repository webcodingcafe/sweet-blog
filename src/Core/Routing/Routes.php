<?php

declare(strict_types=1);

namespace SweetBlog\Core\Routing;

use SweetBlog\App\Controllers\HomeController;
use SweetBlog\Core\Http\HttpMethod;

/**
 * Route registry
 */
final readonly class Routes
{
    /**
     * The route map.
     *
     * @var list<array{0: HttpMethod, 1: string, 2: array{0: class-string, 1: string}}>
     */
    private(set) array $map;

    /**
     * Sets the route map.
     */
    public function __construct()
    {
        $this->map = [
            [HttpMethod::GET, '/', [HomeController::class, 'index']],
            [HttpMethod::HEAD, '/', [HomeController::class, 'index']],
        ];
    }
}
