<?php

/*
 * Copyright (c) 2024 Daniela Kleemann
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace SweetBlog\Controllers;

use SweetBlog\Core\View;

/**
 * Class used to provide the home page.
 */
final readonly class HomeController
{
    /**
     * View constructor,
     *
     * @param View $view
     */
    public function __construct(private View $view) {}

    /**
     * Prints "Hello, world!" on the screen.
     *
     * @return void
     */
    public function __invoke(): void
    {
        $this->view->render('home');
    }
}
