<?php

declare(strict_types=1);

namespace SweetBlog\Core\Routing;

use SweetBlog\Core\Exceptions\ResourceNotFoundException;
use SweetBlog\Core\Http\HttpRequest;

/**
 * Handles routing for clean URLs.
 */
final readonly class Router
{
    public function __construct(
        private(set) HttpRequest $httpRequest = new HttpRequest(),
        private(set) Routes $routes = new Routes(),
    ) {}

    /**
     * Dispatches the request to the corresponding controller.
     *
     * @return array{0: class-string, 1: string} Controller
     * @throws \SweetBlog\Core\Exceptions\ResourceNotFoundException If no route matches the request
     */
    public function dispatch(): array
    {
        foreach ($this->routes->map as $route) {
            [$method, $pattern, $controller] = $route;

            if ($method->value !== $this->httpRequest->method) {
                continue;
            }

            if (preg_match("#^{$pattern}$#", $this->httpRequest->uri) !== 1) {
                continue;
            }

            return $controller;
        }

        throw new ResourceNotFoundException('Route not found');
    }
}
