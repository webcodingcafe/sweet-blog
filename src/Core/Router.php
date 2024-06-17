<?php

/*
 * Copyright (c) 2024 Daniela Kleemann
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace SweetBlog\Core;

use SweetBlog\Exception\HttpNotFoundException;

final readonly class Router
{
    /**
     * Router constructor.
     *
     * @param Request $request
     * @param Routes $routes
     */
    public function __construct(private Request $request, private Routes $routes) {}

    /**
     * Checks if the current request matches a registered route.
     *
     * @return string Controller class name
     * @throws HttpNotFoundException
     */
    public function resolve(): string
    {
        foreach (($this->routes)() as $route) {
            [$method, $pattern, $controller] = $route;

            if ($this->request->method() !== $method) {
                continue;
            }

            if (\preg_match("#^{$pattern}$#", $this->request->uri()) !== 1) {
                continue;
            }

            return $controller;
        }

        throw new HttpNotFoundException('No matching route found.');
    }
}
