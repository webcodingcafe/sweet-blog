<?php

/*
 * Copyright (c) 2024 Daniela Kleemann
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace SweetBlog\Controllers;

/**
 * Class used to provide the home page.
 */
final class HomeController
{
    /**
     * Prints "Hello, world!" on the screen.
     *
     * @return void
     */
    public function __invoke(): void
    {
        echo 'Hello, world!';
    }
}
